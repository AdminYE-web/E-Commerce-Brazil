<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Website')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ date('is') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    @yield('css')
</head>

<body>

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.language-dropdown').forEach(function (dropdown) {
        const toggle = dropdown.querySelector('.language-toggle');

        if (!toggle) return;

        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropdown.classList.toggle('is-open');
        });

        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('is-open');
            }
        });
    });
});

async function LoadGeoCode(zipcode = '') 
{
    if (!zipcode) return null;

    const token = '{{ env('GOOGLE_GEOCODE_KEY') }}';
    const apiUrl = 'https://maps.googleapis.com/maps/api/geocode/json?key='+token+'&address='+zipcode+'&language=ja&sensor=false';
    let data = {
        'mainArea': '',
        'subArea': ''
    };
    
    try {
        const response = await $.ajax({
            url: apiUrl,
            type: 'GET',
            dataType: 'json'
        });

        if (response.status == 'OK') {
            [...response.results[0].address_components].reverse().forEach(function(component) {
                if (component.types.includes('administrative_area_level_1')) {
                    data['mainArea'] = component.long_name;
                }
                if (component.types.includes('locality') || component.types.includes('sublocality')) {
                    data['subArea'] = component.long_name;
                }
            });
        }
        
        return data;
        
    } catch (error) {
        console.error("Geocode error:", error);
        return data;
    }
}

</script>
</body>

@yield('js')

</html>
