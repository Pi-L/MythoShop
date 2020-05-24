/* eslint-disable import/prefer-default-export */

// burger menu
const burgerButton = document.querySelector('.burgerButton');
const sideNavbar = document.querySelector('.side--navbar');



export default function navEvents() {
  burgerButton.addEventListener('click', () => {
    burgerButton.classList.toggle('openBurger');
    sideNavbar.classList.toggle('shown');

  });
}

