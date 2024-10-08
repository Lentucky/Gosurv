document.addEventListener("DOMContentLoaded", function(event) {
   
    const showNavbar = (toggleId, navId, bodyId, headerId) => {
        const toggle = document.getElementById(toggleId);
        const navImg = document.querySelector('.nav_img'),
        nav = document.getElementById(navId),
        bodypd = document.getElementById(bodyId),
        headerpd = document.getElementById(headerId),
        logoImg = document.getElementById("logo-img"); // Select the logo image
        
        // Validate that all variables exist
        if(toggle && nav && bodypd && headerpd){
            toggle.addEventListener('click', () => {
                // Toggle show class for navbar
                nav.classList.toggle('show');
                
                // Change toggle icon
                toggle.classList.toggle('bx-x');
                
                // Adjust body and header padding when navbar is shown
                bodypd.classList.toggle('body-pd');
                headerpd.classList.toggle('body-pd');
    
                // Toggle class for the nav image container
                navImg.classList.toggle('open');
                
                // Check screen width and adjust the logo accordingly
                if (window.innerWidth > 767) {
                    // Mobile screen: small logo when navbar is open
                    logoImg.src = nav.classList.contains('show') ? "img/gosurv.png" : "img/gosurv_small.png";
                } else {
                    // Larger screen: change to large logo when navbar is open
                    logoImg.src = nav.classList.contains('show') ? "img/gosurv_small.png" : "img/gosurv_small.png";
                }
            });
        }
    }
        
    showNavbar('header-toggle','nav-bar','body-pd','header');
        
    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link');
    
    function colorLink(){
        if(linkColor){
            linkColor.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        }
    }
    linkColor.forEach(l => l.addEventListener('click', colorLink));
});
