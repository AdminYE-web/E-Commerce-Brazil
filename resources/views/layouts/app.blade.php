<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Website')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</head>

<body>

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainMenuPanel = document.getElementById('mainMenuPanel');
            const menuPanels = document.querySelectorAll('.mobile-menu-panel');
            const openSubmenuButtons = document.querySelectorAll('.open-submenu');
            const backButtons = document.querySelectorAll('.back-main-menu');
            const mobileMenu = document.getElementById('mobileMenu');

            function resetPanels() {
                menuPanels.forEach(function(panel) {
                    panel.classList.remove('active', 'move-left', 'from-right', 'move-right');
                });

                mainMenuPanel.classList.add('active');
            }

            function openSubmenu(panelId) {
                const targetPanel = document.getElementById(panelId);

                if (!targetPanel) return;

                // reset submenu ก่อน
                menuPanels.forEach(function(panel) {
                    if (panel !== mainMenuPanel) {
                        panel.classList.remove('active', 'move-left', 'move-right');
                        panel.classList.add('from-right');
                    }
                });

                // ให้เมนูหลักอยู่ตรงกลางก่อน
                mainMenuPanel.classList.add('active');
                mainMenuPanel.classList.remove('move-left');

                // เตรียม submenu ให้อยู่ขวา
                targetPanel.classList.add('active', 'from-right');

                // สั่ง animation
                requestAnimationFrame(function() {
                    mainMenuPanel.classList.add('move-left');
                    targetPanel.classList.remove('from-right');
                });
            }

            function backToMain() {
                const activeSubPanel = document.querySelector('.mobile-menu-panel.active:not(#mainMenuPanel)');

                if (!activeSubPanel) return;

                // ให้ main menu กลับมาจากซ้าย
                mainMenuPanel.classList.add('active');
                mainMenuPanel.classList.remove('move-left');

                // ให้ submenu เลื่อนออกไปขวา
                activeSubPanel.classList.add('move-right');

                setTimeout(function() {
                    activeSubPanel.classList.remove('active', 'move-right', 'from-right');
                }, 350);
            }

            openSubmenuButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const target = this.getAttribute('data-target');
                    openSubmenu(target);
                });
            });

            backButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    backToMain();
                });
            });

            if (mobileMenu) {
                mobileMenu.addEventListener('hidden.bs.offcanvas', function() {
                    resetPanels();
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const desktopToggles = document.querySelectorAll('.desktop-menu-toggle');
            const megaMenus = document.querySelectorAll('.desktop-mega-menu');

            function closeAllMegaMenus() {
                megaMenus.forEach(function(menu) {
                    menu.classList.remove('is-open');
                });

                desktopToggles.forEach(function(btn) {
                    btn.classList.remove('is-open');
                });
            }

            desktopToggles.forEach(function(toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (window.innerWidth < 992) return;

                    const targetId = this.getAttribute('data-target');
                    const targetMenu = document.getElementById(targetId);
                    const isAlreadyOpen = targetMenu.classList.contains('is-open');

                    closeAllMegaMenus();

                    if (!isAlreadyOpen) {
                        targetMenu.classList.add('is-open');
                        this.classList.add('is-open');
                    }
                });
            });

            document.addEventListener('click', function(e) {
                const clickedToggle = e.target.closest('.desktop-menu-toggle');
                const clickedMenu = e.target.closest('.desktop-mega-menu');

                if (!clickedToggle && !clickedMenu) {
                    closeAllMegaMenus();
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth < 992) {
                    closeAllMegaMenus();
                }
            });
        });
    </script>


</body>

</html>
