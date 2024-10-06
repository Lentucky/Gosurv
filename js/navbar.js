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
                // Show/hide navbar
                nav.classList.toggle('show');
                
                // Change icon
                toggle.classList.toggle('bx-x');
                
                // Add padding to body and header
                bodypd.classList.toggle('body-pd');
                headerpd.classList.toggle('body-pd');
    
                // Toggle class for the nav image container
                navImg.classList.toggle('open');
                
                // Change the logo based on the navbar state
                if (nav.classList.contains('show')) {
                    logoImg.src = "img/gosurv.png"; // Large logo
                } else {
                    logoImg.src = "img/gosurv_small.png"; // Small logo
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
