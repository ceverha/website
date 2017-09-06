<!DOCTYPE html>
<html>
	<head>
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="snakeicon.ico" >
		<title>Snake</title>
		<style>
			body{
				background-color: #000000;
				overflow: hidden;
			}
			canvas{
				border:1px solid black;
			}
			*{
				font-family: 'Montserrat', sans-serif;
				color:#ffffff;
			}
			table{
				border:1px solid black;

			}
			#scoreTable{
				position:absolute;
				left:720px;
				top:10px;
				color:#ffffff;
				font-size:10px;
			}
			#console{
				color:#ffffff;
				margin-top:10px;
			}
			#colorselect{
				width:50px;
			}
			/*#scorecanvas{
				position:absolute;
				left:10px;
				top: 480px;
			}
			*/
		</style>
	</head>
	<body>
		
		<!-- <h1>Game Two</h1> -->
		<canvas id="gamecanvas" width="700px" height="460px" style="border:2px solid black; border-radius:4px">
			Your browser does not support html5<br/><span style="font-size:5px">cough cough... internet explorer</span>
		</canvas>
		<!--<canvas id="scorecanvas" width = "700px" height = "100px">
		</canvas>-->
	
	</body>
	
	<div id="scoreTable">
	</div>

	<div id="console">
	</div>
	<!--Color Select-->
	<!--<span style="color:#81e0e3">This functionality is currently disabled </span><select id="colorselect">
			<option style="background-color:#606163" value="1"></option>
			<option style="background-color:#6a4a3c" value="2"></option>
			<option style="background-color:#99b2b7" value="3"></option>
			<option style="background-color:#ebebe9" value="4"></option>
			<option style="background-color:#f7e5bf" value="5"></option>

	</select>-->

	
	<div>Want to leave a comment or suggestion? Submit those here (only one every ten seconds, <br/> and no blank comments allowed).</div>
	<textarea id="comment" style="width:400px; height:50px; color:black; float: left; margin-top:5px; 
	background-color:#606163; color:#81e0e3; border: 2px solid black; border-radius: 4px">
	</textarea>
	<button id="commentsubmit" style="margin-top:5px; height:58px; color:black; border: 2px solid black; border-radius: 4px">Submit</button>
	<div style="position:absolute; top:630px"><a href="getAllSnakeComments.php">All Comments</a></div>
	</br></br></br></br>
	<div id="credits" style="position:absolute; top:680px">
		<a href="http://www.jackceverha.com" style="text-decoration:none">
		<span style="color:#baffbe">&copy</span> 
		<span style="color:#81e0e3">2014</span> 
		<span style="color:#91bebf">Jack</span>
		<span style="color:#baffbe">Ceverha</span>
		</a>
	</div>
	<script>
		$(document).ready(function(){
			
			//comment submit code
			document.getElementById("comment").value = "";//clear the form on startup
			document.getElementById("commentsubmit").onclick = function(){
				
				if (document.getElementById("comment").value != ""){//if the field is not blank
					
					var comment = document.getElementById("comment").value;//save the comment
					$.ajax({
						url: 'snakeComments.php',
						data: {'comment': comment}
					});

					document.getElementById("comment").value = "";//clear the form
					document.getElementById("commentsubmit").style.display= 'none';//make the button disappear
					setTimeout(function(){
						document.getElementById("commentsubmit").style.display = 'block';
					},10000);//ten seconds then remake the button
				}
			}

			/*******************************************
			WORK ON getOrientation(index);
			********************************************/
			//alert("hello");//just to see if we are working

			var c = document.getElementById("gamecanvas");
			var g = c.getContext("2d");//to match java syntax better
			
			//var c1 = document.getElementById("scorecanvas");
			//var g1 = c1.getContext("2d");//to match java syntax better

			
			var image = new Image();
			image.src = "cageface.jpg";

			var flash = 1;
			var index = 1;
			var colorCycler = 1;
			//get the initial color input stuff
			var colorArray = new Array();
			if (index == 1){//"i demand a pancake" from colourlovers.com
				colorArray.push("#000000");//background
				colorArray.push("#606163");//canvas background
				//four block colors
				colorArray.push("#baffbe");
				colorArray.push("#81e0e3");
				colorArray.push("#91bebf");
				colorArray.push("#fffce6");
			}
			if (index == 2){//"ocean five" from ||
				colorArray.push("#000000");//background
				colorArray.push("#6a4a3c");//canvas background
				//four block colors
				colorArray.push("#00a0b0");
				colorArray.push("#cc333f");
				colorArray.push("#eb6841");
				colorArray.push("#edc951");
			}
			if (index == 3){//"good friends"
				colorArray.push("#000000");//background
				colorArray.push("#99b2b7");//canvas background
				//four block colors
				colorArray.push("#d5ded9");
				colorArray.push("#d9ceb2");
				colorArray.push("#948c75");
				colorArray.push("#b9af99");

			}
			if (index == 4){//"holy cow yummy bat cat"
				colorArray.push("#000000");//background
				colorArray.push("#ebebe9");//canvas background
				//four block colors
				colorArray.push("#453e36");
				colorArray.push("#371454");
				colorArray.push("#c1b4d1");
				colorArray.push("#fef31b");

			}
			if (index == 5){//"spring afternoon
				colorArray.push("#000000");//background
				colorArray.push("#f7e5bf");//canvas background
				//four block colors
				colorArray.push("#eac57e");
				colorArray.push("#abc6bb");
				colorArray.push("#ef9d94");
				colorArray.push("#c92053");

			}

			//make sure these match the canvas properties above (in the HTML)
			var backgroundColor = colorArray[1];
			var canvasWidth = 700;
			var canvasHeight = 460;

			var frameCount = 0;//total frames that have elapsed

			var image = new Image();//instantiate image variable
			image.src = "http://ecx.images-amazon.com/images/I/510w56KCGDL._SL75_SS50_.jpg";//cage face

			

			var start = false;//game start variable

			var msPerFrame = 65;//milliseconds per frame

			var z = 0;//number used for color cycling

			var move = true;



			function Block(x,y,width,height,color){//canvas = g in this program
				this.x = x;
				this.y = y;
				this.width = width;
				this.height = height;
				this.color = color;
				
				//clear the block
				this.clear = function(){
					g.fillStyle = backgroundColor;
					g.fillRect(this.x, this.y, this.width, this.height);
				};
				//draw the block
				this.draw = function(){
					g.fillStyle = this.color;
					g.fillRect(this.x,this.y,this.width,this.height);
					g.strokeRect(this.x,this.y,this.width,this.height);
					//g.drawImage(image,this.x,this.y,this.width,this.height);
				};
				
				//equivalency based on position
				this.equals = function(b){
					if (this.x == b.x){
						if (this.y == b.y){
							return true;
						}
					}
					return false;
				};
				
			};

			/*****************
				add blink functionality
				images
				different types of edibles
			******************/
			function Edible(block, edibleType){
				this.block = block;
				this.edibleType = edibleType;
				this.x = block.x;
				this.y = block.y;
				
				
			};
			

			function BlockLine(firstBlock){
				this.blockArray = new Array();
				this.numBlocks = 3;//minimum number of segments
				this.firstBlock = firstBlock;
				this.iterator = 0;
				//to be manipulated by keystrokes
				this.xVel = 0;
				this.yVel = 0;

				//general add block method that does different stuff based on the tail orientation 
				//NOTE: will not function if blocksAdded < 3
				this.addBlock = function(edible){
					
					var a = this.blockArray[this.numBlocks - 1];//last block
					var b = this.blockArray[this.numBlocks - 2];//second to last
					
					
					//check the the status of the last two blocks
					if (a.x < b.x)
						this.blockArray.push(new Block(a.x - a.width, a.y, a.width, a.height, edible.block.color));
					if (a.x > b.x)
						this.blockArray.push(new Block(a.x + a.width, a.y, a.width, a.height, edible.block.color));
					if (a.y < b.y)
						this.blockArray.push(new Block(a.x, a.y - a.height, a.width, a.height, edible.block.color));
					if (a.y > b.y)
						this.blockArray.push(new Block(a.x, a.y + a.height, a.width, a.height, edible.block.color));

					

					this.numBlocks++;
				};
				
				this.initiateSnake = function(){//this must be called after instantiating a new blockline for everything to function
					//create the initial snake (length = 3, head of snake = firstBlock from argument)
					this.blockArray.push(firstBlock);//from argument
					this.blockArray.push(new Block(firstBlock.x - firstBlock.width,firstBlock.y,firstBlock.width,firstBlock.height,generateRandomColor() ));//to the left one space
					this.blockArray.push(new Block(firstBlock.x - 2*firstBlock.width,firstBlock.y,firstBlock.width,firstBlock.height,generateRandomColor() ));//to the left two spaces
					
				};
				
				this.returnSnake = function(){//displays key information about each block in the line for use in the console
					var output = "(" + this.xVel + ")-(" + this.yVel + ")<br/>";
					for (var i = 0; i < this.numBlocks; i++){
						output += this.blockArray[i].x + "-" + this.blockArray[i].y + "-" + i + "<br/>";
					}
					output+=snake.collide();
					return output;
				};
				
				this.drawSnake = function(){//draw all the blocks
					for (var i = 0; i < this.numBlocks; i++){
						this.blockArray[i].draw();
					}
				};
				
				this.collide = function(){
					var answer = false;
					for (var i = 1; i < this.numBlocks; i++){ // note that i = 1; if that was not done, line(0) would be compared to line(0) and the snake would always be colliding with itself
						if (this.blockArray[0].equals(this.blockArray[i]))
							answer = true;
					}
					return answer;
				};

				this.collideWall = function(){//check if the snake has hit the wall
					var answer = false;
					if (this.blockArray[0].x >= canvasWidth || this.blockArray[0].x < 0)//right and left walls
						answer = true;
					if (this.blockArray[0].y >= canvasHeight || this.blockArray[0].y < 0)//bottom and top walls
						answer = true;
					return answer;
				};
				
				this.moveSnake = function(){
					for(var i = this.numBlocks - 1; i >= 0; i--){//starting at the last block, and looping to the first inclusive
						if (i != 0){//if the first block is not being referenced
							if(this.iterator == 1){
								this.blockArray[i].x = this.blockArray[i-1].x;//set x of block at i to x of block at i - 1
								this.blockArray[i].y = this.blockArray[i-1].y;//set y of block at i to y of block at i - 1
							}
							
							
						}

						else{//if it's the head, then move it based on the velocity
							
							//if the snake head is just out of bounds
							//use these if statements to make it pass through the walls and appear at the other side
							if (this.collideWall()){
								if(this.blockArray[0].x >= canvasWidth)//right wall
									this.blockArray[0].x = 0;
							
								if (this.blockArray[0].x < 0)//left wall
									this.blockArray[0].x = canvasWidth - this.blockArray[0].width;
								
								if (this.blockArray[0].y >= canvasHeight)//bottom wall
									this.blockArray[0].y = 0;
							
								if (this.blockArray[0].y < 0)//top wall
									this.blockArray[0].y = canvasHeight - this.blockArray[0].height;
							}
							//just add the velocities normally
							else{	
								this.blockArray[i].x += this.xVel;
								this.blockArray[i].y += this.yVel;
							}
						}
					}
					this.iterator++;
					if (this.iterator == 2)
						this.iterator = 1;
				};
				
				//get the orientation of a snake at a specific index
				this.getOrientation = function(index){
					
					ax = this.blockArray[index].x;//middle block
					ay = this.blockArray[index].y;

					bx = this.blockArray[index - 1].x;//first block
					by = this.blockArray[index - 1].y;

					cx = this.blockArray[index + 1].x;//last block
					cy = this.blockArray[index + 1].y;

					if (ax == bx){
						if (ax == cx){//vertical line
							return 1;
						}
					}
					
					if (ay == by){
						if (ay == cy){//horizontal line
							return 2;
						}
					}
					
					if (ax > cy){//c to the left of a
						if (cy < by){//position three on chart
							return 3;
						}
						if (cy > by){
							return 4;//position four on chart
						}
					}
					
					if (ax < cy){//c to the right of a
						if (cy < by){//position 5 on chart
							return 5;
						}
						if (cy > by){//position 6 on chart
							return 6;
						}
					}
					
					if (ax > bx){//b to the left of a
						if (by < cy){//position 7 on chart
							return 7;
						}
						if (by > cy){//position 8 on chart
							return 8;
						}
					}
					
					if (ax < bx){//b to the right of a
						if (by < cy){//position 9 on chart
							return 9;
						}
						if (by > cy){//position 10 on chart
							return 10;
						}
					}
					return "something's broken";
				};

			};
			
			//general methods
			var clearCanvas = function(canvas){
				canvas.fillStyle = colorArray[1];
				canvas.fillRect(0,0,canvasWidth,canvasHeight);
			};
			//for generating edible positions
			var generateRandomXPosition = function(){
				var randx = Math.floor( (Math.random()*canvasWidth) );	//random between 0 and 800 exclusive
				var answer = 0;
				while (true)
				{
					if (randx % 20 == 0){	//is it divisible by 20 ******************* this is the default block width
						answer = randx; //this is the important line
						break;
					}
					else
						randx = Math.floor( (Math.random()*canvasWidth) ); //make another value
				}
				return answer;
			};

			var generateRandomYPosition = function(){
				//generate y
				var randy = Math.floor( (Math.random()*canvasHeight) );	//random between 0 and 800 exclusive
				var answer = 0;
				while (true)
				{
					if (randy % 20 == 0){	//is it divisible by 20 ******************* this is the default block width
						return randy; //this is the important line
						break;
					}
					else
						randy = Math.floor( (Math.random()*canvasHeight) ); //make another value
				}
				return answer;
			};

			var generateRandomColor = function(){
					// var z = Math.floor( Math.random()*4 );
					var color = null;
					if (z == 0)
						color = colorArray[2];
					if (z == 1)
						color = colorArray[3];
					if (z == 2)
						color = colorArray[4];
					if (z == 3){
						color = colorArray[5];
						z = -1;
					}
						
					z++;//cycle to next color

					return color;
					
			};
			

			//make the first snake on startup - perhaps change this to a method createDefaultSnake()
			var b = new Block(300,200,20,20,generateRandomColor());
			var snake = new BlockLine(b);
			snake.initiateSnake();//for some reason this is necessary
			
			var e = new Edible(new Block(0,0,20,20,generateRandomColor()),"default");
			//initiate the first cookie
 			e.block.x = generateRandomXPosition();
 			e.block.y = generateRandomYPosition();
 			//initiate cookie two
 			var e1 = new Edible(new Block(0,0,20,20,generateRandomColor()),"default");
 			e1.block.x = generateRandomXPosition();
 			e1.block.y = generateRandomYPosition();

			//load up the table
			$.ajax({//get the table 
					url:"getSnakeScores.php",
					success:function(result){
						$("#scoreTable").html(result);
					}
				});
 			//color event handler
			$("#colorselect").change(function(){
				index = $("#colorselect").val();
				colorArray = new Array();
				if (index == 1){//"i demand a pancake" from colourlovers.com
					colorArray.push("#000000");//background
					colorArray.push("#606163");//canvas background
					//four block colors
					colorArray.push("#baffbe");
					colorArray.push("#81e0e3");
					colorArray.push("#91bebf");
					colorArray.push("#fffce6");
				}
				if (index == 2){//"ocean five" from ||
					colorArray.push("#000000");//background
					colorArray.push("#6a4a3c");//canvas background
					//four block colors
					colorArray.push("#00a0b0");
					colorArray.push("#cc333f");
					colorArray.push("#eb6841");
					colorArray.push("#edc951");
				}
				if (index == 3){//"good friends"
					colorArray.push("#000000");//background
					colorArray.push("#99b2b7");//canvas background
					//four block colors
					colorArray.push("#d5ded9");
					colorArray.push("#d9ceb2");
					colorArray.push("#948c75");
					colorArray.push("#b9af99");

				}
				if (index == 4){//"holy cow yummy bat cat"
					colorArray.push("#000000");//background
					colorArray.push("#ebebe9");//canvas background
					//four block colors
					colorArray.push("#453e36");
					colorArray.push("#371454");
					colorArray.push("#c1b4d1");
					colorArray.push("#fef31b");

				}
				if (index == 5){//"spring afternoon
				colorArray.push("#000000");//background
				colorArray.push("#f7e5bf");//canvas background
				//four block colors
				colorArray.push("#eac57e");
				colorArray.push("#abc6bb");
				colorArray.push("#ef9d94");
				colorArray.push("#c92053");

				}

				//change existing blocks to match the current scheme
				var colorIndex = 2;
				for (var i = 0; i <snake.numBlocks; i++){
					snake.blockArray[i].color = colorArray[colorIndex];
					if (colorIndex < 5)
						colorIndex++;
					else
						colorIndex = 2;
				}
				//set the cookie color
				e.block.color = colorArray[colorIndex];
				e1.block.color = colorArray[colorIndex];

			});

			
			


			$(document).keydown(function(e){//key handler - this is supposed to be outside the setInterval loop 
				var code = e.which;
				
 					if(code == 38){//up
 						if(! (snake.blockArray[0].y > snake.blockArray[1].y) && snake.yVel != -20){//if the snake is not going down
 						snake.yVel = -20;//default block width
 						snake.xVel = 0;
 						}
 					}
 					if(code == 40){//down
 						if(! (snake.blockArray[0].y < snake.blockArray[1].y) && snake.yVel != 20){//if the snake is not going up
 						snake.yVel = 20;//default block width
 						snake.xVel = 0;
 						}
 					}
 					if(code == 37){//left
 						if(! (snake.blockArray[0].x > snake.blockArray[1].x) && snake.xVel != 20){//if the snake is not going right
 						snake.xVel = -20;//default block width
 						snake.yVel = 0;
 						}
 					}
 					if(code == 39){//right
 						if(! (snake.blockArray[0].x < snake.blockArray[1].x) && snake.xVel != -20){//if the snake is not going left
 						snake.xVel = 20;//default block width
 						snake.yVel = 0;
 						}

 					}
 					if(code == 65){//if 'a' is pressed
 						snake.addBlock(e);
 					}
 					if(code ==32){//if space is pressed
 						start = true;
 					}
 					if(code == 66){//if 'b' is pressed
 						move = false;
 					}
 					
			});

			$(document).keyup(function(e){
				var code = e.which;
				if (code == 66){
					move = true;
				}
			});
			setInterval(function(){//score table display
				
				
				$.ajax({//get the table 
					url:"getSnakeScores.php",
					success:function(result){
						$("#scoreTable").html(result);
					}
				});
				
			},3000);
			/**************************
			this is what is being repeated every msPerFrame milliseconds
			**************************/

			setInterval(function(){
				frameCount++;
				clearCanvas(g);

				snake.drawSnake();
				if (flash == 1 || flash == 2){
					e.block.draw();//draw the edible
					
				}
				else{
					e1.block.draw();//draw the second edible
				}
				flash++;
				if (flash == 5)//draw once every x frames
				flash = 1;
				if (start){//if space has been pressed upon startup or after death
					if (snake.xVel != 0 || snake.yVel != 0){
						if(move){//used for stopping the snake
							snake.moveSnake();
						}
					}	

				}
				
				//draw the scores
				// var x1 = 0;
				// var y1 = 0;
				// for (var i = 0; i < snake.numBlocks; i++){
				// 	if (x1 < canvasWidth){
				// 		g1.fillStyle = snake.blockArray[i].color;
				// 		g1.fillRect(x1,y1,7,7);
				// 		x1 += 20;
				// 	}
				// 	else{

				// 		x1 = 0;
				// 		y1 += 20;
				// 		g1.fillStyle = snake.blockArray[i].color;
				// 		g1.fillRect(x1,y1,7,7);
				// 		x1 += 20;
				// 	}
				// }

				document.getElementById("console").innerHTML =  "Press space then an arrow key to begin. Note: the snake CAN go through walls." + '<br/>'
				 + "Current Score: " + snake.numBlocks;// + '<br/>' + snake.returnSnake();

				/*****************
				if game over - 
					flash
					enter scores
					go to score page? or maybe just have the table on the right side of the screen/below the canvas
					start over
				*************/
				if (snake.blockArray[0].equals(e.block) || snake.blockArray[0].equals(e1.block)){//if you give a snake a cookie
					//alert(colorCycler);
					colorCycler = Math.floor(Math.random()*5 + 1);
					colorArray = new Array();
				if (colorCycler == 1){//"i demand a pancake" from colourlovers.com
					colorArray.push("#000000");//background
					colorArray.push("#606163");//canvas background
					//four block colors
					colorArray.push("#baffbe");
					colorArray.push("#81e0e3");
					colorArray.push("#91bebf");
					colorArray.push("#fffce6");
				}
				if (colorCycler == 2){//"ocean five" from ||
					colorArray.push("#000000");//background
					colorArray.push("#606163");//canvas background
					//four block colors
					colorArray.push("#00a0b0");
					colorArray.push("#cc333f");
					colorArray.push("#eb6841");
					colorArray.push("#edc951");
				}
				if (colorCycler == 3){//"good friends"
					colorArray.push("#000000");//background
					colorArray.push("#606163");//canvas background
					//four block colors
					colorArray.push("#d5ded9");
					colorArray.push("#d9ceb2");
					colorArray.push("#948c75");
					colorArray.push("#b9af99");

				}
				if (colorCycler == 4){//"holy cow yummy bat cat"
					colorArray.push("#000000");//background
					colorArray.push("#606163");//canvas background
					//four block colors
					colorArray.push("#453e36");
					colorArray.push("#371454");
					colorArray.push("#c1b4d1");
					colorArray.push("#fef31b");

				}
				if (colorCycler == 5){//"spring afternoon
				colorArray.push("#000000");//background
				colorArray.push("#606163");//canvas background
				//four block colors
				colorArray.push("#eac57e");
				colorArray.push("#abc6bb");
				colorArray.push("#ef9d94");
				colorArray.push("#c92053");

				}


					
	

					snake.addBlock(e);//add the tail
					
					e.block.x = generateRandomXPosition();
 					e.block.y = generateRandomYPosition();

 					e1.block.x = generateRandomXPosition();
 					e1.block.y = generateRandomYPosition();

 					e.block.color = generateRandomColor();//change the color
 					//e1.block.color = generateRandomColor();
 						
 					snake.addBlock(e);//add the second tail piece
 					
 					e.block.color = generateRandomColor();//change the color again
 					//e1.block.color = generateRandomColor();
					
					snake.addBlock(e);//add the second tail piece
 					
 					e.block.color = generateRandomColor();//change the color again
 					//e1.block.color = generateRandomColor();
					
					//snake.addBlock(e);//add the second tail piece
 					
 					//e.block.color = generateRandomColor();//change the color again
					
					//snake.addBlock(e);//add the second tail piece
 					
 					//e.block.color = generateRandomColor();//change the color again


 					// for (var i = 0; i < snake.numBlocks; i++){//increase the size of the blocks
 					// 	snake.blockArray[i].width++;
 					// 	snake.blockArray[i].height++;
 					// }
 					
				}

				if (snake.collide()){//|| snake.collideWall()
					alert("GAME OVER! Final Score = " + snake.numBlocks);
					var name = prompt("Enter your name");

					if (snake.numBlocks > 3 && name != ""){
						$.ajax({
							url : "snakeScores.php",
							data : {'score': snake.numBlocks, 'name': name}
							
						});
					}

					start = false;
					snake = null;
					z = 0;//start over the color cycling
					snake = new BlockLine(new Block(400,300,20,20,generateRandomColor()));
					snake.initiateSnake();
					e.block.color = generateRandomColor();//change cookie color
					e1.block.color = generateRandomColor();
					//g1.fillStyle = colorArray[0];
					//g1.fillRect(0,0,canvasWidth,100);

					//document.getElementById("console").innerHTML += "GAME OVER";
				}
			},msPerFrame);

		});
	</script>
</html>


