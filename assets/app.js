import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

function openCard(e)
{
    console.log(e.target)
    e.target.parentNode.querySelector("p").classList.toggle("open")
}

document.querySelectorAll(".button-card").forEach((v)=>
{
    addEventListener("click", openCard)
})