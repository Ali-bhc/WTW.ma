'use strict';

const btnFetured = document.getElementById('featured-btn');
const btnTrending = document.getElementById('trending-btn');
const btnNewest = document.getElementById('newest-btn');

const featuredgMovies = document.getElementById('featured-movies');
const trendinggMovies = document.getElementById('trending-movies');
const newestMovies = document.getElementById('newest-movies');

const filterRadios = document.querySelector('.filter-radios');

const header = document.querySelector("header");
const nav = document.querySelector('nav');
const navbarMenuBtn = document.querySelector('.navbar-menu-btn');

const navbarForm = document.querySelector('.navbar-form');
const navbarFormCloseBtn = document.querySelector('.navbar-form-close');
const navbarSearchBtn = document.querySelector('.navbar-search-btn');

function filterByFTN()
{
    if(btnNewest.checked)
    {
        trendinggMovies.classList.add("hide-class");
        featuredgMovies.classList.add("hide-class");
        newestMovies.classList.remove("hide-class");
    }

    if(btnFetured.checked)
    {
        featuredgMovies.classList.remove("hide-class");

        trendinggMovies.classList.add("hide-class");
        newestMovies.classList.add("hide-class");

    }

    if(btnTrending.checked)
    {
        trendinggMovies.classList.remove("hide-class");
        featuredgMovies.classList.add("hide-class");
        newestMovies.classList.add("hide-class");
    }
}

function navIsActive(){
    header.classList.toggle('active');
    nav.classList.toggle('active');
    navbarMenuBtn.classList.toggle('active');

}

const searchBarIsActive = () => navbarForm.classList.toggle('active');


filterByFTN();

filterRadios.addEventListener("click", function (){
    filterByFTN();
});

navbarMenuBtn.addEventListener("click", navIsActive);

navbarSearchBtn.addEventListener("click", searchBarIsActive);

navbarFormCloseBtn.addEventListener('click', searchBarIsActive)



/***** Bookmarking ******/














