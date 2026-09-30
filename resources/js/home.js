document.addEventListener('DOMContentLoaded', function () {
    const scrollToTop = document.getElementById('scrollToTop');

    if (!scrollToTop) {
        return;
    }

    let lastScrollTop = window.scrollY;

    function showScrollButton() {
        scrollToTop.classList.remove(
            'opacity-0',
            'translate-y-5',
            'scale-90',
            'pointer-events-none'
        );

        scrollToTop.classList.add(
            'opacity-100',
            'translate-y-0',
            'scale-100'
        );
    }

    function hideScrollButton() {
        scrollToTop.classList.remove(
            'opacity-100',
            'translate-y-0',
            'scale-100'
        );

        scrollToTop.classList.add(
            'opacity-0',
            'translate-y-5',
            'scale-90',
            'pointer-events-none'
        );
    }

    window.addEventListener('scroll', function () {
        const currentScrollTop = window.scrollY;

        // Đang kéo lên
        if (currentScrollTop < lastScrollTop && currentScrollTop > 300) {
            showScrollButton();
        }

        // Đang kéo xuống
        if (currentScrollTop > lastScrollTop) {
            hideScrollButton();
        }

        // Đã về gần đầu trang
        if (currentScrollTop <= 300) {
            hideScrollButton();
        }

        lastScrollTop = currentScrollTop;
    });

    scrollToTop.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});