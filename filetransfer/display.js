

$(document).ready(function(){
	
	//setup canvas
	var c = document.getElementById("gamecanvas");
	var canvas = c.getContext("2d");
	var mode = 1;

	var image = new Image();
	if (mode == 1)
	image.src = "spaceship.png";
	if (mode == 2)
	image.src = "car.png";	
	function Block(x,y,width,height,color){
		this.x = x;
		this.y = y;
		this.width = width;
		this.height = height;
		this.color = color;
		
	};

	Block.prototype.draw=function(){
		canvas.fillStyle="#000000";
		//canvas.strokeRect(0,0,this.width,this.height);
		canvas.drawImage(image,0,0,this.width,this.height);
	};

	function Particle(x,y,width,height,color,xVel,yVel,maxAge){
		this.x = x;
		this.y = y;
		this.width = width;
		this.height = height;
		this.color = color;
		this.xVel = xVel;
		this.yVel = yVel;
		this.maxAge = maxAge;
		this.age = 0;
	};

	Particle.prototype.draw = function(){
		canvas.fillStyle = this.color;
		canvas.fillRect(this.x,this.y,this.width,this.height);
		//canvas.drawImage(image,this.x,this.y,this.width,this.height);
	}

	function Loc(x,y){
		this.x = x;
		this.y = y;
	};

	var angle = 0;
	var angleV = 0;
	var block = new Block(0,0,30,30,"#000000");
	var xVel = 0;
	var yVel = 0;
	var vel = 0;
	var forward = false;
	var dotArray = new Array();
	var colliding = false;
	var particles = new Array();
	var explode = false;
	var exhaustParticles = new Array();
	
	
	$(document).keydown(function(e){
		var code = e.which;
 		if(code == 87){//w
 			forward = true;
 		}
 		if(code == 83){//s
 			
 		}
 		if(code == 65){//a
 			angleV= -1 * Math.PI / 16;
 		}
 		if(code == 68){//d
 			angleV= Math.PI / 16;
 		}
 		if(code == null){
 			
 		}
 	});
 	$(document).keyup(function(e){
		var code = e.which;
 		if(code == 87){//w
 			forward = false;
 			
 		}
 		if(code == 83){//s
 			explode = true;
 		}
 		if(code == 65){//a
 			angleV=0;
 		}
 		if(code == 68){//d
 			angleV=0;
 		}
 		if(code == null){
 			
 		}
 	});

 	

	setInterval(function(){
		//clear the screen	
		canvas.fillStyle = "#ffffff";
		canvas.fillRect(0,0,800,600);

		xVel = vel * Math.cos(angle);
 		yVel = vel * Math.sin(angle);

 		var numExhaustParticles = 30;
		if(forward){
			//draw rocket particle effects
			//same spot as the tempLoc below
			for (var i = 0; i < numExhaustParticles; i++){
				exhaustParticles.unshift(new Particle(block.x + block.width/2 - Math.cos(angle)*block.width/2,
													block.y + block.height/2 - block.height*Math.sin(angle)/2,
													1,1,"#000000",4 * -Math.cos(angle) + (Math.random()*3-1.5), 
													4 * -Math.sin(angle) + (Math.random()*3-1.5), 15));
			}

			if (vel < 14)//the speed limit
				vel+=.4;
		}

		if(vel > 0){//decrease the speed
			vel -= .25;
			//add new points at the tail of the ship
			var tempLoc = new Loc(block.x + block.width/2 - Math.cos(angle)*block.width/2,block.y + block.height/2 - block.height*Math.sin(angle)/2);
			dotArray.unshift(tempLoc);
		}
		
		if(vel <= 0){
			vel = 0;
		}
		angle += angleV;
		document.getElementById("display").innerHTML = exhaustParticles.length;
		
		//ship rotation
		canvas.save();
		canvas.translate(block.x,block.y);
		canvas.translate(block.width/2,block.height/2);
		canvas.rotate(angle);
		canvas.translate(-1 * block.width/2, -1 * block.height/2);
		

		//draw here

		block.x += xVel;
		block.y += yVel;
		block.draw();
		canvas.restore();

		
		//draw line
		
		var r = 120;
		var g = 0;
		var b = 0;
		for (var i = 0; i < dotArray.length - 1; i++){
			
			g+= 255 / dotArray.length;
			b+= 255 / dotArray.length;
			for (var j = 0; j < 4; j++){
				canvas.beginPath();
				canvas.strokeStyle = "rgb(" + r +"," + Math.floor(g) + "," + Math.floor(b) + ")";	
				canvas.lineTo(dotArray[i].x,dotArray[i].y);
				canvas.lineTo(dotArray[i+1].x,dotArray[i+1].y);
				canvas.stroke();
			}
		}
		g = 0;
		b = 0;

		//draw exhaust
		for (var i = 0; i < exhaustParticles.length; i++){
			exhaustParticles[i].x += exhaustParticles[i].xVel;
			exhaustParticles[i].y += exhaustParticles[i].yVel;

			exhaustParticles[i].draw();

			exhaustParticles[i].age++;

			if (exhaustParticles[i].age == exhaustParticles[i].maxAge)
				exhaustParticles[i].color = "#555555";
			if (exhaustParticles[i].age > exhaustParticles[i].maxAge)
				exhaustParticles[i].color = "#aaaaaa";
			if (exhaustParticles[i].age > exhaustParticles[i].maxAge + 1)
				exhaustParticles.splice(i,1);
		}

		//number of particles that issue from the explosion
		var numExplosionParticles = 50;
		//explosion
		//triggered by keyup on 's'
		if (colliding){
			for (var i = 0; i < numExplosionParticles; i++){
				particles.unshift(new Particle( Math.random()*block.width + block.x, Math.random()*block.height + block.y, 
									2, 2, "#000000", Math.random()*6 - 3, Math.random()*6 - 3 , 20 ) );
			}
			explode = false;
		}
		//draw explosion particles
		for (var i = 0; i < particles.length; i++){
			//move the particles
			particles[i].x += particles[i].xVel;
			particles[i].y += particles[i].yVel;
			particles[i].draw();

			particles[i].age++;

			if (particles[i].age == particles[i].maxAge)
				particles[i].color = "#555555";
			if (particles[i].age > particles[i].maxAge)
				particles[i].color = "#aaaaaa";
			if (particles[i].age > particles[i].maxAge + 1)
				particles.splice(i,1);
			//change the velocities - random
			// particles[i].xVel = Math.random()*6 - 3;
			// particles[i].yVel = Math.random()*6 - 3;
			//change the velocities - random but in a path
			// particles[i].xVel += Math.random()*2 - 1;
			// particles[i].yVel += Math.random()*2 - 1;
		}
		//limit the number of particles
		var maxParticles = 1000;
		if (particles.length > maxParticles){
			particles.splice(maxParticles,particles.length - maxParticles);
		}


		//collision detection
		//change so that only points that don't collide can be created (if (!colliding){add point} )
		//and set the initial iterator below (i) to 0
		colliding = false;
		document.getElementById("display2").innerHTML = "";
		for (var i = 20; i < dotArray.length; i++){// i = 20 so it doesn't collide with the most recent segments
			if (dotArray[i].x > block.x){
				if (dotArray[i].x < block.x + block.width){
					if (dotArray[i].y > block.y){
						if (dotArray[i].y < block.y + block.height)
							//did collide
							colliding = true;
						
					}
				}
			}
		}
		document.getElementById("display2").innerHTML = colliding;

		var tailLength = 100;
		//chop the end of the tail
		if (dotArray.length > tailLength){
			dotArray.splice(tailLength,dotArray.length - tailLength);
		}
		


	},1000/30);
});