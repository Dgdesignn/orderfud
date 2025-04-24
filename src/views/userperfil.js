// script.js
const profile  = document.querySelector('.profile-photo')
const imgprofile  = document.querySelector('.imgprofile')
const preview  = document.querySelector('.imgpreview')

profile.addEventListener('click',()=>{
    imgprofile.click()
    imgprofile.addEventListener('change',function(event){
        const file = event.target.files[0]
        const reader = new FileReader()
        reader.onload = function(e){
            preview.src =e.target.result
        }
        reader.readAsDataURL(file)
    })
})
 


document.addEventListener('DOMContentLoaded', function () {
  const menuToggle = document.getElementById('menu-toggle'); 
  const sidebar = document.getElementById('sidebar'); 
 
  menuToggle.addEventListener('click', function () {
    sidebar.classList.toggle('hide'); 
  });
});






class MobileNavbar {
    constructor(mobileMenu, navList, navLinks) {
      this.mobileMenu = document.querySelector(mobileMenu);
      this.navList = document.querySelector(navList);
      this.navLinks = document.querySelectorAll(navLinks);
      this.activeClass = "active";
  
      this.handleClick = this.handleClick.bind(this);
    }
  
    animateLinks() {
      this.navLinks.forEach((link, index) => {
        link.style.animation
          ? (link.style.animation = "")
          : (link.style.animation = `navLinkFade 0.5s ease forwards ${
              index / 7 + 0.3
            }s`);
      });
    }
  
    handleClick() {
      this.navList.classList.toggle(this.activeClass);
      this.mobileMenu.classList.toggle(this.activeClass);
      this.animateLinks();
    }
  
    addClickEvent() {
      this.mobileMenu.addEventListener("click", this.handleClick);
    }
  
    init() {
      if (this.mobileMenu) {
        this.addClickEvent();
      }
      return this;
    }
  }
  
  const mobileNavbar = new MobileNavbar(
    ".mobile-menu",
    ".nav-list",
    ".nav-list li",
  );
  mobileNavbar.init();
