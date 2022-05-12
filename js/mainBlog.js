const f = document.querySelector('.contenedor-carousel-blog');
const blogs = document.querySelectorAll('.blog');

const flechaIz = document.getElementById('flecha-izquierda-blog');
const flechaDe = document.getElementById('flecha-derecha-blog');

// ? ----- ----- Event Listener para la flecha derecha. ----- -----
flechaDe.addEventListener('click', () => {
	f.scrollLeft += f.offsetWidth;

	const indicadorAct = document.querySelector('.indicadores-blog .activo-blog');
	if(indicadorAct.nextSibling){
		indicadorAct.nextSibling.classList.add('activo-blog');
		indicadorAct.classList.remove('activo-blog');
	}
});

// ? ----- ----- Event Listener para la flecha izquierda. ----- -----
flechaIz.addEventListener('click', () => {
	f.scrollLeft -= f.offsetWidth;

	const indicadorAct = document.querySelector('.indicadores-blog .activo-blog');
	if(indicadorAct.previousSibling){
		indicadorAct.previousSibling.classList.add('activo-blog');
		indicadorAct.classList.remove('activo-blog');
	}
});

// ? ----- ----- Paginacion ----- -----
const numeroPaa = Math.ceil(blogs.length / 5);
for(let i = 0; i < numeroPaa; i++){
	const indic = document.createElement('button');

	if(i === 0){
		indic.classList.add('activo-blog');
	}

	document.querySelector('.indicadores-blog').appendChild(indic);
	indic.addEventListener('click', (p) => {
		f.scrollLeft = i * f.offsetWidth;

		document.querySelector('.indicadores-blog .activo-blog').classList.remove('activo-blog');
		p.target.classList.add('activo-blog');
	});
}

// ? ----- ----- Hover ----- -----
blogs.forEach((blog) => {
	blog.addEventListener('mouseenter', (p) => {
		const el = p.currentTarget;
		setTimeout(() => {
			blogs.forEach(blog => blog.classList.remove('hover'));
			el.classList.add('hover');
		}, 300);
	});
});

f.addEventListener('mouseleave', () => {
	blogs.forEach(blog => blog.classList.remove('hover'));
});