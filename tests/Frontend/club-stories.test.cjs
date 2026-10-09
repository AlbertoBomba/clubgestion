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

function viewerHarness(video = null) {
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
        querySelector: (selector) => buttons[selector],
        querySelectorAll: (selector) => selector === '[data-story-slide]' ? slides : progress,
    };
    const document = {
        ...element(), readyState: 'complete',
        querySelectorAll: (selector) => selector === '[data-story-viewer]' ? [viewer] : [],
    };
    let frame;
    const context = vm.createContext({
        document, requestAnimationFrame: (callback) => { frame = callback; },
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
