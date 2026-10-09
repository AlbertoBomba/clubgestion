function initializeStories() {
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
            if (video) video.currentTime = 0;
            if (automatic) setAutomatic(true);
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
            touchStart = { x: event.changedTouches[0].clientX, y: event.changedTouches[0].clientY };
        }, { passive: true });
        viewer.addEventListener('touchend', (event) => {
            if (!touchStart || event.target.closest('video, button')) return;
            const dx = event.changedTouches[0].clientX - touchStart.x;
            const dy = event.changedTouches[0].clientY - touchStart.y;
            if (Math.abs(dx) > 60 && Math.abs(dx) > Math.abs(dy)) show(index + (dx < 0 ? 1 : -1));
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
            if (document.hidden) setAutomatic(false);
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
        requestAnimationFrame(frame);
    });

    document.querySelectorAll('[data-story-upload]').forEach((form) => {
        if (form.dataset.initialized) return;
        form.dataset.initialized = 'true';
        const input = form.querySelector('input[type="file"]');
        const error = form.querySelector('[data-upload-error]');
        input.addEventListener('change', () => {
            const files = [...input.files];
            const list = form.querySelector('[data-upload-list]');
            list.replaceChildren();
            files.forEach((file) => {
                const item = document.createElement('li');
                item.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(1)} MB)`;
                list.append(item);
            });
            const invalid = files.some((file) =>
                !['image/jpeg', 'image/png', 'image/webp', 'video/mp4', 'video/webm'].includes(file.type) ||
                file.size > (file.type.startsWith('image/') ? 10 : 50) * 1024 * 1024);
            const message = files.length > 10 ? 'Selecciona como máximo 10 archivos.' :
                invalid ? 'Revisa los formatos y tamaños: imágenes de hasta 10 MB y vídeos de hasta 50 MB.' : '';
            error.textContent = message;
            input.setCustomValidity(message);
        });
        form.addEventListener('submit', () => {
            form.querySelector('button[type="submit"]').disabled = true;
            form.querySelector('[data-upload-status]').textContent = 'Enviando tu historia y sus archivos. No cierres esta página.';
        });
    });
}

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initializeStories);
else initializeStories();
document.addEventListener('livewire:navigated', initializeStories);
