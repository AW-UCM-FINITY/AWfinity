const fi = document.querySelector('.contenedor-carousel-bso');
const bsos = document.querySelectorAll('.bso');

const flechaI = document.getElementById('flecha-izquierda-bso');
const flechaD = document.getElementById('flecha-derecha-bso');

// ? ----- ----- Event Listener para la flecha derecha. ----- -----
flechaD.addEventListener('click', () => {
	fi.scrollLeft += fi.offsetWidth;

	const indicadorAc = document.querySelector('.indicadores-bso .activo-bso');
	if(indicadorAc.nextSibling){
		indicadorAc.nextSibling.classList.add('activo-bso');
		indicadorAc.classList.remove('activo-bso');
	}
});

// ? ----- ----- Event Listener para la flecha izquierda. ----- -----
flechaI.addEventListener('click', () => {
	fi.scrollLeft -= fi.offsetWidth;

	const indicadorAc = document.querySelector('.indicadores-bso .activo-bso');
	if(indicadorAc.previousSibling){
		indicadorAc.previousSibling.classList.add('activo-bso');
		indicadorAc.classList.remove('activo-bso');
	}
});

// ? ----- ----- Paginacion ----- -----
const numeroP = Math.ceil(bsos.length / 5);
for(let i = 0; i < numeroP; i++){
	const ind = document.createElement('button');

	if(i === 0){
		ind.classList.add('activo-bso');
	}

	document.querySelector('.indicadores-bso').appendChild(ind);
	ind.addEventListener('click', (p) => {
		fi.scrollLeft = i * fi.offsetWidth;

		document.querySelector('.indicadores-bso .activo-bso').classList.remove('activo-bso');
		p.target.classList.add('activo-bso');
	});
}

// ? ----- ----- Hover ----- -----
bsos.forEach((bso) => {
	bso.addEventListener('mouseenter', (p) => {
		const ele = p.currentTarget;
		setTimeout(() => {
			bsos.forEach(bso => bso.classList.remove('hover'));
			ele.classList.add('hover');
		}, 300);
	});
});

fi.addEventListener('mouseleave', () => {
	bsos.forEach(bso => bso.classList.remove('hover'));
});