function initializeStories() {
    document.querySelectorAll('[data-story-feed-video]').forEach((video) => {
        if (video.dataset.initialized) return;
        video.dataset.initialized = 'true';
        const status = video.parentElement.querySelector('[data-story-video-status]');
        let visible = false;
        function updatePlayback() {
            if (!visible || document.hidden) {
                video.pause();
                return;
            }
            video.muted = true;
            video.play().then(() => { status.textContent = ''; }).catch(() => {
                if (visible && !document.hidden) status.textContent = 'Pulsa reproducir para ver el vídeo.';
            });
        }
        if (typeof IntersectionObserver === 'function') {
            const observer = new IntersectionObserver(([entry]) => {
                visible = entry.isIntersecting && entry.intersectionRatio >= 0.5;
                updatePlayback();
            }, { threshold: [0, 0.5] });
            observer.observe(video);
            document.addEventListener('visibilitychange', updatePlayback);
        }
        video.addEventListener('error', () => {
            status.textContent = 'No se puede reproducir este vídeo en tu navegador.';
        });
    });

    document.querySelectorAll('[data-story-viewer]').forEach((viewer) => {
        if (viewer.dataset.initialized) return;
        viewer.dataset.initialized = 'true';
        const slides = [...viewer.querySelectorAll('[data-story-slide]')];
        const progress = [...viewer.querySelectorAll('[data-story-progress]')];
        const play = viewer.querySelector('[data-story-play]');
        let index = 0;
        let automatic = false;
        let elapsed = 0;
        let lastFrame = null;
        let touchStart = null;
        let swiped = false;
        let viewerVisible = typeof IntersectionObserver !== 'function';
        const lightbox = viewer.querySelector('[data-story-lightbox]');
        if (lightbox) {
            const enlargedImage = lightbox.querySelector('[data-story-lightbox-image]');
            viewer.querySelectorAll('[data-story-enlarge]').forEach((link) => {
                link.addEventListener('click', (event) => {
                    if (swiped) {
                        event.preventDefault();
                        swiped = false;
                        return;
                    }
                    if (typeof lightbox.showModal !== 'function') return;
                    event.preventDefault();
                    setAutomatic(false);
                    enlargedImage.src = link.href;
                    enlargedImage.alt = link.querySelector('img').alt;
                    lightbox.showModal();
                });
            });
            lightbox.querySelector('[data-story-lightbox-close]').addEventListener('click', () => lightbox.close());
            lightbox.addEventListener('click', (event) => {
                if (event.target === lightbox) lightbox.close();
            });
            lightbox.addEventListener('keydown', (event) => event.stopPropagation());
        }
        const currentVideo = () => slides[index].querySelector('video');

        function setAutomatic(value) {
            automatic = value;
            lastFrame = null;
            play.textContent = automatic ? 'Pausar reproducción' : 'Reproducción automática';
            play.setAttribute('aria-pressed', String(automatic));
            const video = currentVideo();
            if (video) {
                if (automatic) video.play().catch(() => {
                    setAutomatic(false);
                    viewer.querySelector('[data-story-counter]').textContent = 'El navegador no permite la reproducción automática. Usa los controles del vídeo.';
                });
                else video.pause();
            }
        }

        function show(next) {
            if (next < 0 || next >= slides.length) {
                setAutomatic(false);
                return;
            }
            currentVideo()?.pause();
            index = next;
            elapsed = 0;
            lastFrame = null;
            slides.forEach((slide, position) => {
                slide.hidden = position !== index;
                progress[position].style.width = position < index ? '100%' : '0%';
            });
            viewer.querySelector('[data-story-counter]').textContent = `${index + 1} / ${slides.length}`;
            viewer.querySelector('[data-story-prev]').disabled = index === 0;
            viewer.querySelector('[data-story-next]').disabled = index === slides.length - 1;
            const video = currentVideo();
            if (video) {
                video.currentTime = 0;
                video.muted = true;
            }
            if (automatic) setAutomatic(true);
            else if (video && viewerVisible && !document.hidden) {
                video.play().catch(() => {
                    if (currentVideo() === video) {
                        viewer.querySelector('[data-story-counter]').textContent = 'Pulsa reproducir para ver el vídeo.';
                    }
                });
            }
        }

        viewer.querySelector('[data-story-prev]').addEventListener('click', () => show(index - 1));
        viewer.querySelector('[data-story-next]').addEventListener('click', () => show(index + 1));
        play.addEventListener('click', () => {
            if (!automatic && elapsed >= 7000) show(0);
            setAutomatic(!automatic);
        });
        viewer.addEventListener('keydown', (event) => {
            if (event.target.closest('video')) return;
            if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
                event.preventDefault();
                show(index + (event.key === 'ArrowRight' ? 1 : -1));
            }
        });
        viewer.addEventListener('touchstart', (event) => {
            if (lightbox?.open) return;
            swiped = false;
            touchStart = { x: event.changedTouches[0].clientX, y: event.changedTouches[0].clientY };
        }, { passive: true });
        viewer.addEventListener('touchend', (event) => {
            if (lightbox?.open) return;
            if (!touchStart || event.target.closest('video, button')) return;
            const dx = event.changedTouches[0].clientX - touchStart.x;
            const dy = event.changedTouches[0].clientY - touchStart.y;
            if (Math.abs(dx) > 60 && Math.abs(dx) > Math.abs(dy)) {
                swiped = true;
                show(index + (dx < 0 ? 1 : -1));
            }
            touchStart = null;
        }, { passive: true });
        slides.forEach((slide) => {
            const video = slide.querySelector('video');
            video?.addEventListener('ended', () => {
                if (automatic && currentVideo() === video) show(index + 1);
            });
            video?.addEventListener('error', () => {
                if (currentVideo() === video) {
                    setAutomatic(false);
                    viewer.querySelector('[data-story-counter]').textContent = 'No se puede reproducir este vídeo. Prueba otro navegador o el siguiente archivo.';
                }
            });
        });
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                setAutomatic(false);
                currentVideo()?.pause();
            }
        });
        function frame(time) {
            if (!viewer.isConnected) return;
            if (automatic && !document.hidden) {
                const video = currentVideo();
                if (video) {
                    progress[index].style.width = `${video.duration ? video.currentTime / video.duration * 100 : 0}%`;
                } else {
                    if (lastFrame !== null) elapsed += time - lastFrame;
                    progress[index].style.width = `${Math.min(elapsed / 7000 * 100, 100)}%`;
                    if (elapsed >= 7000) show(index + 1);
                }
                lastFrame = time;
            }
            requestAnimationFrame(frame);
        }
        show(0);
        if (typeof IntersectionObserver === 'function') {
            const observer = new IntersectionObserver(([entry]) => {
                viewerVisible = entry.isIntersecting && entry.intersectionRatio >= 0.5;
                const video = currentVideo();
                if (!viewerVisible || document.hidden) {
                    setAutomatic(false);
                    video?.pause();
                } else if (video && !video.ended) {
                    video.muted = true;
                    video.play().catch(() => {
                        if (viewerVisible && currentVideo() === video && !document.hidden) {
                            viewer.querySelector('[data-story-counter]').textContent = 'Pulsa reproducir para ver el vídeo.';
                        }
                    });
                }
            }, { threshold: [0, 0.5] });
            observer.observe(viewer);
        }
        requestAnimationFrame(frame);
    });

    document.querySelectorAll('[data-story-upload]').forEach((form) => {
        if (form.dataset.initialized) return;
        form.dataset.initialized = 'true';
        const input = form.querySelector('input[type="file"]');
        const error = form.querySelector('[data-upload-error]');
        const capture = form.querySelector('[data-video-capture]');
        const list = form.querySelector('[data-upload-list]');
        const count = form.querySelector('[data-upload-count]');
        const files = [];
        const urls = new Set();
        const supported = ['image/jpeg', 'image/png', 'image/webp', 'video/mp4', 'video/webm', 'video/quicktime'];
        input.removeAttribute('name');
        capture.disabled = false;
        form.querySelector('[data-capture-control]').hidden = false;
        form.querySelector('[data-record-video]').addEventListener('click', () => capture.click());

        function renderFiles() {
            urls.forEach((url) => URL.revokeObjectURL(url));
            urls.clear();
            list.replaceChildren();
            count.textContent = `${files.length} / 10 archivos`;
            files.forEach((file, index) => {
                const item = document.createElement('li');
                item.className = 'relative overflow-hidden rounded-xl border border-gray-200 bg-white min-w-0';
                const url = URL.createObjectURL(file);
                urls.add(url);
                const isVideo = file.type.startsWith('video/');
                const preview = document.createElement(isVideo ? 'video' : 'img');
                preview.src = url;
                preview.className = 'story-upload-preview';
                if (isVideo) {
                    preview.controls = true;
                    preview.playsInline = true;
                    preview.preload = 'metadata';
                    preview.setAttribute('aria-label', `Vista previa de ${file.name}`);
                } else {
                    preview.alt = `Vista previa de ${file.name}`;
                }
                const details = document.createElement('p');
                details.className = 'p-3 text-xs text-gray-600 break-words';
                details.textContent = `${index + 1}. ${file.name} · ${(file.size / 1024 / 1024).toFixed(1)} MB`;
                preview.addEventListener('error', () => {
                    details.textContent = `${file.name} · No se puede mostrar la vista previa en este navegador. El archivo sigue seleccionado para el envío.`;
                });
                const remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'story-upload-remove';
                remove.textContent = '×';
                remove.setAttribute('aria-label', `Quitar ${file.name}`);
                remove.addEventListener('click', () => {
                    files.splice(index, 1);
                    error.textContent = '';
                    renderFiles();
                    input.focus();
                });
                item.append(preview, details, remove);
                list.append(item);
            });
        }

        function addFiles(picker) {
            const messages = [];
            [...picker.files].forEach((file) => {
                if (!supported.includes(file.type)) {
                    messages.push(`${file.name}: formato no compatible. Usa JPG, PNG, WebP, MP4, WebM o MOV.`);
                } else if (file.size > (file.type.startsWith('image/') ? 10 : 50) * 1024 * 1024) {
                    messages.push(`${file.name}: supera el límite de ${file.type.startsWith('image/') ? 10 : 50} MB.`);
                } else if (files.some((existing) => existing.name === file.name && existing.size === file.size && existing.lastModified === file.lastModified)) {
                    messages.push(`${file.name}: ya está añadido.`);
                } else if (files.length >= 10) {
                    messages.push(`${file.name}: puedes añadir como máximo 10 archivos.`);
                } else {
                    files.push(file);
                }
            });
            picker.value = '';
            error.textContent = messages.join(' ');
            renderFiles();
        }

        input.addEventListener('change', () => addFiles(input));
        capture.addEventListener('change', () => addFiles(capture));
        form.addEventListener('formdata', (event) => {
            files.forEach((file) => event.formData.append('media[]', file, file.name));
        });
        form.addEventListener('submit', () => {
            form.querySelector('button[type="submit"]').disabled = true;
            form.querySelector('[data-upload-status]').textContent = 'Enviando tu historia y sus archivos. No cierres esta página.';
        });
        window.addEventListener('pageshow', () => {
            form.querySelector('button[type="submit"]').disabled = false;
            form.querySelector('[data-upload-status]').textContent = '';
        });
        window.addEventListener('pagehide', (event) => {
            if (!event.persisted) urls.forEach((url) => URL.revokeObjectURL(url));
        });
    });
}

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initializeStories);
else initializeStories();
document.addEventListener('livewire:navigated', initializeStories);
