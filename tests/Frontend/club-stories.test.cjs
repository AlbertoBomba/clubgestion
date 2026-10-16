const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const { test } = require('node:test');
const vm = require('node:vm');

function element() {
    const listeners = {};
    return {
        dataset: {}, style: {}, hidden: false, disabled: false, attributes: {},
        textContent: '', isConnected: true,
        addEventListener(name, callback) { listeners[name] = callback; },
        setAttribute(name, value) { this.attributes[name] = value; },
        emit(name, event = {}) { listeners[name]?.(event); },
    };
}

function viewerHarness(video = null, lightbox = null, links = [], observerClass = undefined) {
    const slides = Array.from({ length: 3 }, (_, index) => ({
        ...element(), querySelector: () => index === 1 ? video : null,
    }));
    const progress = slides.map(() => element());
    const buttons = {
        '[data-story-play]': element(),
        '[data-story-counter]': element(),
        '[data-story-prev]': element(),
        '[data-story-next]': element(),
    };
    const viewer = {
        ...element(),
        querySelector: (selector) => selector === '[data-story-lightbox]' ? lightbox : buttons[selector],
        querySelectorAll: (selector) => selector === '[data-story-slide]' ? slides :
            selector === '[data-story-enlarge]' ? links : progress,
    };
    const document = {
        ...element(), readyState: 'complete',
        querySelectorAll: (selector) => selector === '[data-story-viewer]' ? [viewer] : [],
    };
    let frame;
    const context = vm.createContext({
        document, IntersectionObserver: observerClass, requestAnimationFrame: (callback) => { frame = callback; },
    });
    vm.runInContext(fs.readFileSync(path.join(__dirname, '../../resources/js/club-stories.js'), 'utf8'), context);
    return { slides, progress, buttons, viewer, document, tick: (time) => frame(time) };
}

test('manual arrows, keyboard and swipe select only one slide and stop at boundaries', () => {
    const { slides, buttons, viewer } = viewerHarness();
    assert.equal(buttons['[data-story-prev]'].disabled, true);
    buttons['[data-story-next]'].emit('click');
    assert.deepEqual(slides.map((slide) => slide.hidden), [true, false, true]);
    assert.equal(buttons['[data-story-counter]'].textContent, '2 / 3');
    viewer.emit('keydown', { key: 'ArrowRight', target: { closest: () => null }, preventDefault() {} });
    assert.equal(buttons['[data-story-next]'].disabled, true);
    viewer.emit('touchstart', { changedTouches: [{ clientX: 50, clientY: 50 }] });
    viewer.emit('touchend', { changedTouches: [{ clientX: 140, clientY: 52 }], target: { closest: () => null } });
    assert.equal(buttons['[data-story-counter]'].textContent, '2 / 3');
});

test('automatic images advance at seven seconds, stop at the end and restart', () => {
    const { buttons, progress, tick } = viewerHarness();
    buttons['[data-story-play]'].emit('click');
    tick(0);
    tick(6999);
    assert.equal(buttons['[data-story-counter]'].textContent, '1 / 3');
    tick(7000);
    assert.equal(buttons['[data-story-counter]'].textContent, '2 / 3');
    assert.equal(progress[0].style.width, '100%');
    tick(14000);
    assert.equal(buttons['[data-story-counter]'].textContent, '3 / 3');
    tick(21000);
    assert.equal(buttons['[data-story-play]'].attributes['aria-pressed'], 'false');
    buttons['[data-story-play]'].emit('click');
    assert.equal(buttons['[data-story-counter]'].textContent, '1 / 3');
});

test('backgrounding the page pauses automatic progress', () => {
    const { buttons, document, tick } = viewerHarness();
    buttons['[data-story-play]'].emit('click');
    tick(0);
    tick(1000);
    document.hidden = true;
    document.emit('visibilitychange');
    assert.equal(buttons['[data-story-play]'].attributes['aria-pressed'], 'false');
    tick(10000);
    assert.equal(buttons['[data-story-counter]'].textContent, '1 / 3');
});

test('automatic videos advance on ended, not the image timer', () => {
    const video = {
        ...element(), duration: 20, currentTime: 0,
        play: () => Promise.resolve(), pause() {},
    };
    const { buttons, progress, tick } = viewerHarness(video);
    buttons['[data-story-next]'].emit('click');
    buttons['[data-story-play]'].emit('click');
    tick(0);
    video.currentTime = 10;
    tick(10000);
    assert.equal(buttons['[data-story-counter]'].textContent, '2 / 3');
    assert.equal(progress[1].style.width, '50%');
    video.emit('ended');
    assert.equal(buttons['[data-story-counter]'].textContent, '3 / 3');
});

test('selecting a video starts muted playback without enabling automatic slide advancement', () => {
    let plays = 0;
    let pauses = 0;
    const video = {
        ...element(), currentTime: 5, muted: false,
        play() { plays++; return Promise.resolve(); },
        pause() { pauses++; },
    };
    const { buttons } = viewerHarness(video);
    buttons['[data-story-next]'].emit('click');
    assert.equal(plays, 1);
    assert.equal(video.muted, true);
    assert.equal(video.currentTime, 0);
    assert.equal(buttons['[data-story-play]'].attributes['aria-pressed'], undefined);
    buttons['[data-story-next]'].emit('click');
    assert.ok(pauses > 0);
});

test('detail videos wait until visible, pause on scrolling away and resume when visible again', async () => {
    let plays = 0;
    let pauses = 0;
    let intersection;
    const video = {
        ...element(), currentTime: 0,
        play() { plays++; return Promise.resolve(); },
        pause() { pauses++; },
    };
    class IntersectionObserver {
        constructor(callback) { intersection = callback; }
        observe() {}
    }
    const { buttons } = viewerHarness(video, null, [], IntersectionObserver);
    buttons['[data-story-next]'].emit('click');
    assert.equal(plays, 0);
    intersection([{ isIntersecting: true, intersectionRatio: 0.75 }]);
    await Promise.resolve();
    assert.equal(plays, 1);
    assert.equal(video.muted, true);
    intersection([{ isIntersecting: true, intersectionRatio: 0.25 }]);
    assert.ok(pauses > 0);
    assert.equal(plays, 1);
    intersection([{ isIntersecting: true, intersectionRatio: 0.75 }]);
    assert.equal(plays, 2);
});

test('category changes submit directly from the template without requiring the compiled bundle', () => {
    let submissions = 0;
    const template = fs.readFileSync(path.join(__dirname, '../../resources/views/webclubs/stories/index.blade.php'), 'utf8');
    const handler = template.match(/<select[^>]*id="category"[^>]*onchange="([^"]+)"/);
    assert.ok(handler, 'The category select must submit without a bundle initialization listener.');
    vm.runInNewContext(`(function () { ${handler[1]} }).call(select)`, {
        select: { form: { requestSubmit() { submissions++; } } },
    });
    assert.equal(submissions, 1);
});

test('feed videos play only while visible and pause on background or leaving the viewport', async () => {
    let plays = 0;
    let pauses = 0;
    let intersection;
    const status = element();
    const video = {
        ...element(), parentElement: { querySelector: () => status },
        play() { plays++; return Promise.resolve(); },
        pause() { pauses++; },
    };
    const document = {
        ...element(), readyState: 'complete', hidden: false,
        querySelectorAll: (selector) => selector === '[data-story-feed-video]' ? [video] : [],
    };
    class IntersectionObserver {
        constructor(callback) { intersection = callback; }
        observe(target) { assert.equal(target, video); }
    }
    vm.runInNewContext(fs.readFileSync(path.join(__dirname, '../../resources/js/club-stories.js'), 'utf8'), { document, IntersectionObserver });
    intersection([{ isIntersecting: true, intersectionRatio: 0.5 }]);
    await Promise.resolve();
    assert.equal(plays, 1);
    assert.equal(video.muted, true);
    intersection([{ isIntersecting: false, intersectionRatio: 0 }]);
    assert.equal(pauses, 1);
    document.hidden = true;
    document.emit('visibilitychange');
    assert.equal(pauses, 2);
    assert.equal(plays, 1);
    video.emit('error');
    assert.match(status.textContent, /No se puede reproducir/);
});

test('blocked autoplay reports a visible error and turns automatic mode off', async () => {
    const video = {
        ...element(), duration: 20, currentTime: 0,
        play: () => Promise.reject(new Error('Playback blocked')), pause() {},
    };
    const { buttons } = viewerHarness(video);
    buttons['[data-story-next]'].emit('click');
    buttons['[data-story-play]'].emit('click');
    await Promise.resolve();
    assert.equal(buttons['[data-story-play]'].attributes['aria-pressed'], 'false');
    assert.match(buttons['[data-story-counter]'].textContent, /no permite/);
});

test('clicking a photo opens its full image, pauses autoplay and allows closing', () => {
    const image = element();
    const close = element();
    const lightbox = {
        ...element(), open: false,
        querySelector: (selector) => selector === '[data-story-lightbox-image]' ? image : close,
        showModal() { this.open = true; },
        close() { this.open = false; },
    };
    const link = { ...element(), href: '/historias/archivos/42', querySelector: () => ({ alt: 'Foto del torneo' }) };
    const { buttons, tick } = viewerHarness(null, lightbox, [link]);
    buttons['[data-story-play]'].emit('click');
    let prevented = false;
    link.emit('click', { preventDefault() { prevented = true; } });
    assert.equal(prevented, true);
    assert.equal(lightbox.open, true);
    assert.equal(image.src, link.href);
    assert.equal(image.alt, 'Foto del torneo');
    assert.equal(buttons['[data-story-play]'].attributes['aria-pressed'], 'false');
    tick(0);
    tick(10000);
    assert.equal(buttons['[data-story-counter]'].textContent, '1 / 3');
    close.emit('click');
    assert.equal(lightbox.open, false);
});

test('swiping a photo changes slides without accidentally opening the enlarged image', () => {
    const lightbox = { ...element(), querySelector: () => element(), showModal() { throw new Error('Should not open'); } };
    const link = element();
    const { viewer, buttons } = viewerHarness(null, lightbox, [link]);
    viewer.emit('touchstart', { changedTouches: [{ clientX: 150, clientY: 50 }] });
    viewer.emit('touchend', { changedTouches: [{ clientX: 50, clientY: 52 }], target: { closest: () => null } });
    let prevented = false;
    link.emit('click', { preventDefault() { prevented = true; } });
    assert.equal(prevented, true);
    assert.equal(buttons['[data-story-counter]'].textContent, '2 / 3');
});

function uploadHarness() {
    const revoked = [];
    const inputs = {
        'input[type="file"]': { ...element(), files: [], value: '', removeAttribute(name) { delete this.attributes[name]; }, focus() {} },
        '[data-video-capture]': { ...element(), files: [], value: '', click() { this.clicked = true; } },
        '[data-upload-error]': element(),
        '[data-upload-list]': { ...element(), children: [], replaceChildren() { this.children = []; }, append(item) { this.children.push(item); } },
        '[data-upload-count]': element(),
        '[data-capture-control]': element(),
        '[data-record-video]': element(),
        'button[type="submit"]': element(),
        '[data-upload-status]': element(),
    };
    const form = { ...element(), querySelector: (selector) => inputs[selector] };
    const window = element();
    const document = {
        ...element(), readyState: 'complete',
        querySelectorAll: (selector) => selector === '[data-story-upload]' ? [form] : [],
        createElement: () => ({
            ...element(), children: [],
            append(...items) { this.children.push(...items); },
        }),
    };
    vm.runInNewContext(fs.readFileSync(path.join(__dirname, '../../resources/js/club-stories.js'), 'utf8'), {
        document, window,
        URL: { createObjectURL: (file) => `blob:${file.name}`, revokeObjectURL: (url) => revoked.push(url) },
    });
    function choose(files, selector = 'input[type="file"]') {
        inputs[selector].files = files;
        inputs[selector].emit('change');
    }
    function submittedFiles() {
        const submitted = [];
        form.emit('formdata', { formData: { append: (key, file) => submitted.push({ key, file }) } });
        return submitted;
    }
    return { form, window, inputs, choose, submittedFiles, revoked };
}

function file(name, type = 'image/jpeg', size = 1024) {
    return { name, type, size, lastModified: 1 };
}

test('successive selections and mobile capture accumulate files in multipart order', () => {
    const { inputs, choose, submittedFiles } = uploadHarness();
    choose([file('one.jpg'), file('two.jpg')]);
    choose([file('three.png', 'image/png')]);
    inputs['[data-record-video]'].emit('click');
    assert.equal(inputs['[data-video-capture]'].clicked, true);
    choose([file('mobile.mov', 'video/quicktime')], '[data-video-capture]');
    assert.deepEqual(submittedFiles().map(({ key, file }) => [key, file.name]), [
        ['media[]', 'one.jpg'], ['media[]', 'two.jpg'], ['media[]', 'three.png'], ['media[]', 'mobile.mov'],
    ]);
    assert.equal(inputs['[data-upload-count]'].textContent, '4 / 10 archivos');
    assert.equal(inputs['input[type="file"]'].value, '');
    assert.equal(inputs['[data-upload-list]'].children[3].children[0].controls, true);
});

test('removal updates submission and revokes preview URLs; removed files can be added again', () => {
    const { inputs, choose, submittedFiles, revoked } = uploadHarness();
    choose([file('one.jpg'), file('two.jpg')]);
    inputs['[data-upload-list]'].children[0].children[2].emit('click');
    assert.deepEqual(submittedFiles().map(({ file }) => file.name), ['two.jpg']);
    assert.ok(revoked.includes('blob:one.jpg'));
    choose([file('one.jpg')]);
    assert.deepEqual(submittedFiles().map(({ file }) => file.name), ['two.jpg', 'one.jpg']);
});

test('duplicates and invalid formats are reported without dropping valid selected files', () => {
    const { inputs, choose, submittedFiles } = uploadHarness();
    choose([file('one.jpg')]);
    choose([file('one.jpg'), file('bad.svg', 'image/svg+xml'), file('two.jpg')]);
    assert.match(inputs['[data-upload-error]'].textContent, /ya está añadido/);
    assert.match(inputs['[data-upload-error]'].textContent, /formato no compatible/);
    assert.deepEqual(submittedFiles().map(({ file }) => file.name), ['one.jpg', 'two.jpg']);
    choose([]);
    assert.equal(submittedFiles().length, 2);
});

test('exact image/video size limits pass and oversized files are excluded with explicit errors', () => {
    const { inputs, choose, submittedFiles } = uploadHarness();
    choose([
        file('exact.jpg', 'image/jpeg', 10 * 1024 * 1024),
        file('large.jpg', 'image/jpeg', 10 * 1024 * 1024 + 1),
        file('exact.mov', 'video/quicktime', 50 * 1024 * 1024),
        file('large.mov', 'video/quicktime', 50 * 1024 * 1024 + 1),
    ]);
    assert.equal(submittedFiles().length, 2);
    assert.match(inputs['[data-upload-error]'].textContent, /10 MB/);
    assert.match(inputs['[data-upload-error]'].textContent, /50 MB/);
});

test('ten-file limit applies across batches and rejected files are not sent', () => {
    const { inputs, choose, submittedFiles } = uploadHarness();
    choose(Array.from({ length: 9 }, (_, index) => file(`${index}.jpg`)));
    choose([file('last.jpg'), file('extra.jpg')]);
    assert.equal(submittedFiles().length, 10);
    assert.match(inputs['[data-upload-error]'].textContent, /máximo 10 archivos/);
    assert.equal(inputs['[data-upload-list]'].children.length, 10);
});

test('returning from navigation restores the submit button and final page exit releases previews', () => {
    const { inputs, choose, form, window, revoked } = uploadHarness();
    choose([file('one.jpg')]);
    form.emit('submit');
    assert.equal(inputs['button[type="submit"]'].disabled, true);
    window.emit('pageshow');
    assert.equal(inputs['button[type="submit"]'].disabled, false);
    window.emit('pagehide', { persisted: false });
    assert.ok(revoked.includes('blob:one.jpg'));
});

test('unsupported preview codecs show an explanation without removing the selected video', () => {
    const { inputs, choose, submittedFiles } = uploadHarness();
    choose([file('iphone.mov', 'video/quicktime')]);
    const preview = inputs['[data-upload-list]'].children[0];
    preview.children[0].emit('error');
    assert.match(preview.children[1].textContent, /No se puede mostrar la vista previa/);
    assert.equal(submittedFiles()[0].file.name, 'iphone.mov');
});

function trackerHarness(fetchImpl) {
    const label = element();
    const video = {
        ...element(), paused: false, currentTime: 0,
        dataset: { storyViewUrl: '/historias/archivos/7/reproducciones', storyViewToken: 'token-123' },
        parentElement: { querySelectorAll: (selector) => selector === '[data-story-view-count]' ? [label] : [] },
    };
    const requests = [];
    const document = {
        ...element(), readyState: 'complete',
        querySelectorAll: (selector) => selector === 'video[data-story-view-url]' ? [video] : [],
    };
    vm.runInNewContext(fs.readFileSync(path.join(__dirname, '../../resources/js/club-stories.js'), 'utf8'), {
        document, fetch: (url, options) => { requests.push({ url, options }); return fetchImpl(); },
    });
    const playTo = (...times) => times.forEach((time) => { video.currentTime = time; video.emit('timeupdate'); });
    return { video, label, requests, playTo };
}

const flush = () => new Promise((resolve) => setImmediate(resolve));

test('video views are sent once after three seconds of continuous playback and update the label', async () => {
    const { video, label, requests, playTo } = trackerHarness(() => Promise.resolve({ ok: true, json: () => ({ counted: true, views: 1234 }) }));
    video.emit('play');
    playTo(1, 2, 2.9);
    assert.equal(requests.length, 0);
    playTo(3.2, 4, 5);
    assert.equal(requests.length, 1);
    assert.equal(requests[0].url, '/historias/archivos/7/reproducciones');
    assert.equal(requests[0].options.method, 'POST');
    assert.equal(requests[0].options.credentials, 'same-origin');
    assert.equal(requests[0].options.headers['X-CSRF-TOKEN'], 'token-123');
    await flush();
    assert.equal(label.textContent, '1.234 reproducciones');
    video.currentTime = 0;
    playTo(1, 2, 3, 4);
    assert.equal(requests.length, 1);
});

test('seeking, loop restarts and paused time do not count as watched playback', () => {
    const { video, requests, playTo } = trackerHarness(() => Promise.resolve({ ok: true, json: () => ({ views: 1 }) }));
    video.emit('play');
    playTo(1);
    video.emit('seeking');
    playTo(20, 21);
    playTo(0.5);
    video.paused = true;
    playTo(1.5, 2.5, 3.5);
    assert.equal(requests.length, 0);
    video.paused = false;
    video.emit('play');
    playTo(1.5, 2);
    assert.equal(requests.length, 0);
    playTo(2.5);
    assert.equal(requests.length, 1);
});

test('a single view uses singular wording and network failures allow a later retry', async () => {
    let fail = true;
    const { video, label, requests, playTo } = trackerHarness(() => fail
        ? Promise.reject(new Error('offline'))
        : Promise.resolve({ ok: true, json: () => ({ views: 1 }) }));
    video.emit('play');
    playTo(1, 2, 3);
    assert.equal(requests.length, 1);
    await flush();
    fail = false;
    playTo(4, 5, 6);
    assert.equal(requests.length, 2);
    await flush();
    assert.equal(label.textContent, '1 reproducción');
});
