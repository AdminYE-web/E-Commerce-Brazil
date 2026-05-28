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
    const backMainButtons = document.querySelectorAll('.back-main-menu');
    const backSubmenuButtons = document.querySelectorAll('.back-submenu');
    const mobileMenu = document.getElementById('mobileMenu');

    function clearMotionClasses(panel) {
        panel.classList.remove('from-right', 'from-left', 'move-left', 'move-right');
    }

    function resetPanels() {
        menuPanels.forEach(function(panel) {
            panel.classList.remove('active', 'from-right', 'from-left', 'move-left', 'move-right');
        });

        if (mainMenuPanel) {
            mainMenuPanel.classList.add('active');
        }
    }

    function getActivePanel() {
    return Array.from(menuPanels).find(function(panel) {
        return panel.classList.contains('active') &&
            !panel.classList.contains('move-left') &&
            !panel.classList.contains('move-right');
    });
}
    function goForward(targetId) {
        const targetPanel = document.getElementById(targetId);
        const currentPanel = getActivePanel();

        if (!targetPanel || !currentPanel || targetPanel === currentPanel) {
            return;
        }

        menuPanels.forEach(function(panel) {
            if (panel !== currentPanel && panel !== targetPanel) {
                panel.classList.remove('active', 'from-right', 'from-left', 'move-left', 'move-right');
            }
        });

        clearMotionClasses(currentPanel);
        clearMotionClasses(targetPanel);

        targetPanel.classList.add('active', 'from-right');

        requestAnimationFrame(function() {
            currentPanel.classList.add('move-left');
            targetPanel.classList.remove('from-right');
        });

        setTimeout(function() {
            currentPanel.classList.remove('active', 'move-left');
        }, 340);
    }

   function goBack(targetId) {
    const targetPanel = document.getElementById(targetId);
    const currentPanel = Array.from(menuPanels).find(function(panel) {
        return panel.classList.contains('active') &&
            !panel.classList.contains('move-left') &&
            !panel.classList.contains('move-right');
    });

    if (!targetPanel || !currentPanel || targetPanel === currentPanel) {
        return;
    }

    menuPanels.forEach(function(panel) {
        if (panel !== currentPanel && panel !== targetPanel) {
            panel.classList.remove('active', 'from-right', 'from-left', 'move-left', 'move-right');
        }
    });

    clearMotionClasses(currentPanel);
    clearMotionClasses(targetPanel);

    /*
    |--------------------------------------------------------------------------
    | Back animation
    |--------------------------------------------------------------------------
    | currentPanel: ออกไปทางขวา
    | targetPanel: เริ่มจากซ้าย แล้วเข้ามาตรงกลาง
    |--------------------------------------------------------------------------
    */
    // ปิดการใช้ transition ชั่วคราวเพื่อให้กระโดดไปตำแหน่ง -100% ทางซ้ายทันทีโดยไม่มีแอนิเมชัน
    targetPanel.style.transition = 'none';
    targetPanel.classList.add('active', 'from-left');

    // บังคับ browser ให้ประมวลผลตำแหน่งเริ่มต้นจากซ้ายก่อน
    targetPanel.offsetHeight;

    // เปิดการใช้ transition คืนค่าเดิม
    targetPanel.style.transition = '';

    // ใช้ requestAnimationFrame เพื่อให้การเลื่อนแอนิเมชันเกิดขึ้นอย่างราบรื่นในเฟรมถัดไป
    requestAnimationFrame(function() {
        currentPanel.classList.add('move-right');
        targetPanel.classList.remove('from-left');
    });

    setTimeout(function() {
        currentPanel.classList.remove('active', 'move-right', 'from-right', 'from-left', 'move-left');
    }, 360);
}

    openSubmenuButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            goForward(target);
        });
    });

    backMainButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            goBack('mainMenuPanel');
        });
    });

    backSubmenuButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const target = this.getAttribute('data-target') || 'mainMenuPanel';
            goBack(target);
        });
    });

    if (mobileMenu) {
        mobileMenu.addEventListener('hidden.bs.offcanvas', function() {
            resetPanels();
        });
    }

    resetPanels();
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const announcementBar = document.getElementById('announcementBar');

    if (!announcementBar) {
        return;
    }

    function toggleAnnouncementBar() {
        if (window.scrollY > 0) {
            announcementBar.classList.add('is-hidden');
        } else {
            announcementBar.classList.remove('is-hidden');
        }
    }

    window.addEventListener('scroll', toggleAnnouncementBar);
    toggleAnnouncementBar();
});
</script>
</body>

@yield('js')

</html>
