'use strict';

/*


-------------------------------------------------- MÉTHODES


*/

const FadeIn = (p_elt, p_display = 'block') => {
	// ----- Init
	let cible, fadeIncr;
	cible = document.querySelector(p_elt);
	cible.style.opacity = 0;
	cible.style.display = p_display;
	fadeIncr = 0.1;

	// ----- Traitement
	(function Anim() {
		let opacite;
		opacite = parseFloat(cible.style.opacity);
		if (!((opacite += fadeIncr) > 1)) {
			cible.style.opacity = opacite;
			requestAnimationFrame(Anim);
		} // if (!((opacite += fadeIncr) > 1)) {
	})(); // (function Anim() {
}; // let FadeIn = (p_elt, p_display = 'block') => {

const FadeOut = (p_elt) => {
	// ----- Init
	let cible, fadeIncr;
	cible = document.querySelector(p_elt);
	fadeIncr = 0.1;
	cible.style.opacity = 1;

	// ----- Traitement
	(function Anim() {
		if ((cible.style.opacity -= fadeIncr) < 0) {
			cible.style.display = 'none';
		} else {
			requestAnimationFrame(Anim);
		} // if ((cible.style.opacity -= fadeIncr) < 0) {
	})(); // (function Anim() {
}; // const FadeOut = (p_elt) => {

/*
	
	
	-------------------------------------------------- UNE FOIS LE DOM CHARGÉ
	
	
*/

document.addEventListener('DOMContentLoaded', () => {
	let device = {};

	// ---------- DETECTION device
	const Device = () => {
		if (window.innerWidth < 768) {
			device.phone = true;
			device.tablet = false;
			device.desktop = false;
		} else if (window.innerWidth >= 768 && window.innerWidth < 1024) {
			device.phone = false;
			device.tablet = true;
			device.desktop = false;
		} else if (window.innerWidth >= 1024) {
			device.phone = false;
			device.tablet = false;
			device.desktop = true;
		} else {
			console.error(`Device non détecté`);
		}
	}; // const Device = () => {

	Device();
	window.onresize = Device;
	// ---------- /DETECTION device

	// ---------- MENU mobile
	// Cette fonctionnalité ne concerne que le smartphone et la tablette verticale
	if (!device.desktop) {
		const btn_open = document.querySelector('#menu-ouvrir');
		const btn_close = document.querySelector('#menu-fermer');

		btn_open.addEventListener('click', () => {
			FadeIn('#navigation');
		});
		btn_close.addEventListener('click', () => {
			FadeOut('#navigation');
		});
	} // if (!device.desktop) {
	// ---------- /MENU mobile
}); // document.addEventListener('DOMContentLoaded', () => {
