const  sideMenu = document.querySelector('aside');
const menuBtn = document.querySelector('#menu_bar');
const closeBtn = document.querySelector('#close_btn');


const themeToggler = document.querySelector('.theme-toggler');



menuBtn.addEventListener('click',()=>{
       sideMenu.style.display = "block"
})
closeBtn.addEventListener('click',()=>{
    sideMenu.style.display = "none"
})

themeToggler.addEventListener('click',()=>{
     document.body.classList.toggle('dark-theme-variables')
     themeToggler.querySelector('span:nth-child(1').classList.toggle('active')
     themeToggler.querySelector('span:nth-child(2').classList.toggle('active')
})





// --------------------------------------------------------------


  function toggleSection(sectionToShow, clickedLink) {
    const sections = ["sec-1", "sec-2","sec-21", "sec-3", "sec-4", "sec-5"];

    // Show or hide sections
    for (const section of sections) {
      const element = document.getElementById(section);
      if (element) {
        element.style.display = section === sectionToShow ? "block" : "none";
      }
    }

    // Remove 'active' class from all links and add it to the clicked one
    const links = document.querySelectorAll('a');
    links.forEach(link => link.classList.remove('active'));
    clickedLink.classList.add('active');

    // Save the active section to sessionStorage
    sessionStorage.setItem("activeSection", sectionToShow);
  }

  // On page load, restore the active section
  window.onload = function() {
    const activeSection = sessionStorage.getItem("activeSection") || "sec-1"; // Default to sec-1 if no section is active
    const links = document.querySelectorAll('a');
    
    // Show the stored active section
    toggleSection(activeSection, [...links].find(link => link.getAttribute('onclick').includes(activeSection)));
  }

  

  // detailes_request.php

  //const section =document.querySelector(".section-popup"),
