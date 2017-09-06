class Entity {
	constructor(radius, xPos, yPos, xVel, yVel, color, display) {
		this.radius = radius;
		this.xPos = xPos;
		this.yPos = yPos;
		this.xVel = xVel;
		this.yVel = yVel;
		this.color = color;
		this.display = display;
	}
}

const frameRate = 35;
$(document).ready(() => {
	// inititiate random size and x/y speed values
	// set interval to start moving then around
	// each entity has size, color, xvel, yvel, and display
	// display can be a boolean or a [0,1] float that represents
	// opacity (alpha)

	// listen to scrollspy activate event, then change display
	// settings based on the current section of the page

	// eg. transition from #1 to #2 
	// signal display for the 2nd set of moving entities
	// this can be with immediate visualization or by fading in
	var width = document.body.clientWidth;
	var height = document.body.clientHeight;

	var canvas = document.getElementById("myCanvas");
	canvas.width = width;
	canvas.height = height;
	var drawContext = canvas.getContext("2d");
	const entities = createEntities(width, height, 25);
	let drawInt = setInterval(() => {
		clearCanvas(drawContext, width, height);
		drawEntities(entities, drawContext, width, height);
	}, 1000 / frameRate);

	// resume icon
	document.getElementById("resume").onmouseover = function(){
		document.getElementById("buttoninfo").innerHTML = "Resum&eacute";
		document.getElementById("buttoninfo").style.color = "#81e0e3";
	}
	document.getElementById("resume").onmouseout = function(){
		document.getElementById("buttoninfo").innerHTML = "";
	}
	
	// snake icon (xbox)
	document.getElementById("snake").onmouseover = function(){
		document.getElementById("buttoninfo").innerHTML = "Snake";
		document.getElementById("buttoninfo").style.color = "#baffbe";
	}
	document.getElementById("snake").onmouseout = function(){
		document.getElementById("buttoninfo").innerHTML = "";
	}
	
	// get initial display settings
	var prevDisplay = document.getElementById("original").style.display;
	var prevHidden = document.getElementById("hidden").style.display;
	// hide bio
	document.getElementById("hidden").style.display = "none";
	
	// bio display
	document.getElementById("about").onclick = function(){
		document.getElementById("hidden").style.display = prevHidden;
		document.getElementById("original").style.display = "none";
	}
	document.getElementById("home").onclick = function(){
		document.getElementById("hidden").style.display = "none";
		document.getElementById("original").style.display = prevDisplay;
	}
});

function createEntities(width, height, n) {
	let entities = [];
	for (let i = 0; i < n; i++) {
		entities.push(createRandomEntity(width, height));
	}
	return entities;
}

const buffer = 300;
function createRandomEntity(width, height) {
	const radius = 80;
	const x = Math.round(Math.random() * (width - buffer*2) + buffer);
	const y = Math.round(Math.random() * (height - buffer*2) + buffer);
	// const xVel = Math.round(Math.random() * 10 - 5);
	// const yVel = Math.round(Math.random() * 10 - 5);
	const xVel = Math.random() * 8 - 4;
	const yVel = Math.random() * 8 - 4;
	const color = getRandomColor();
	return new Entity(radius, x, y, xVel, yVel, color, 1);
}

const colors = ['#e2b60b', '#3393ac', '#cf641c', '#fffdd0'];
function getRandomColor() {
	return colors[Math.round(Math.random() * colors.length)];
}

function clearCanvas(drawContext, width, height) {
	drawContext.clearRect(0, 0, width, height);
}

function drawEntities(entities, drawContext, width, height){
	for (let i = 0; i < entities.length; i++) {
		entities[i] = updateLocation(entities[i], width, height);
		if (entities[i].display) {
			drawContext.globalAlpha = 0.15;
			drawContext.fillStyle = entities[i].color;
			// drawContext.fillRect(entities[i].xPos, entities[i].yPos, entities[i].radius, entities[i].radius);
			drawContext.beginPath();
			drawContext.arc(entities[i].xPos, entities[i].yPos, entities[i].radius, 0, 2 * Math.PI);
			drawContext.fill();
		}
	}
}

function updateLocation(entity, width, height) {
	let newX = entity.xPos + entity.xVel;
	let newY = entity.yPos + entity.yVel;
	
	// edge bouncing
	if (newX + entity.radius > width) {
		newX = width - entity.radius;
		entity.xVel = -1 * entity.xVel;
	}
	if (newX < entity.radius) {
		newX = entity.radius;
		entity.xVel = -1 * entity.xVel;
	}
	if (newY + entity.radius > height) {
		newXY = height - entity.radius;
		entity.yVel = -1 * entity.yVel;
	}
	if (newY < entity.radius) {
		newY = entity.radius;
		entity.yVel = -1 * entity.yVel;
	}

	entity.xPos = newX;
	entity.yPos = newY;
	return entity;
}


