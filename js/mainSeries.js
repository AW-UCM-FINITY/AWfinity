const fil = document.querySelector('.contenedor-carousel-serie');
const series = document.querySelectorAll('.serie');

const flechaIzq = document.getElementById('flecha-izquierda-serie');
const flechaDer = document.getElementById('flecha-derecha-serie');

// ? ----- ----- Event Listener para la flecha derecha. ----- -----
flechaDer.addEventListener('click', () => {
	fil.scrollLeft += fil.offsetWidth;

	const indicadorActiv = document.querySelector('.indicadores-serie .activo-serie');
	if(indicadorActiv.nextSibling){
		indicadorActiv.nextSibling.classList.add('activo-serie');
		indicadorActiv.classList.remove('activo-serie');
	}
});

// ? ----- ----- Event Listener para la flecha izquierda. ----- -----
flechaIzq.addEventListener('click', () => {
	fil.scrollLeft -= fil.offsetWidth;

	const indicadorActiv = document.querySelector('.indicadores-serie .activo-serie');
	if(indicadorActiv.previousSibling){
		indicadorActiv.previousSibling.classList.add('activo-serie');
		indicadorActiv.classList.remove('activo-serie');
	}
});

// ? ----- ----- Paginacion ----- -----
const numeroPag = Math.ceil(series.length / 5);
for(let i = 0; i < numeroPag; i++){
	const indi = document.createElement('button');

	if(i === 0){
		indi.classList.add('activo-serie');
	}

	document.querySelector('.indicadores-serie').appendChild(indi);
	indi.addEventListener('click', (p) => {
		fil.scrollLeft = i * fil.offsetWidth;

		document.querySelector('.indicadores-serie .activo-serie').classList.remove('activo-serie');
		p.target.classList.add('activo-serie');
	});
}

// ? ----- ----- Hover ----- -----
series.forEach((serie) => {
	serie.addEventListener('mouseenter', (p) => {
		const elem = p.currentTarget;
		setTimeout(() => {
			series.forEach(serie => serie.classList.remove('hover'));
			elem.classList.add('hover');
		}, 300);
	});
});

fil.addEventListener('mouseleave', () => {
	series.forEach(serie => serie.classList.remove('hover'));
});