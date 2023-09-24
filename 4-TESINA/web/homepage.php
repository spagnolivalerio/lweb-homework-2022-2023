<?php 
	session_start();
?>

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<link rel="stylesheet" href="../res/css/background.css" type="text/css" />
	<link rel="stylesheet" href="../res/css/homepage/homepage.css" type="text/css" />
</head>

<body>
	<div class="circle" id="circle1"></div>
	<div class="circle" id="circle2"></div>
	<div class="circle" id="circle3"></div>
	<div class="circle" id="circle4"></div>
	<div class="circle" id="circle5"></div>
	<div class="circle" id="circle6"></div>

	<script>
		
		const circle1 = document.getElementById('circle1');
		const circle2 = document.getElementById('circle2');
		const circle3 = document.getElementById('circle3');
		const circle4 = document.getElementById('circle4');
		const circle5 = document.getElementById('circle5');
		const circle6 = document.getElementById('circle6');

		let time = 0;
		let angle = 0;
		const frequency = 0.0005;
		const amplitude = 600;
		const radius = 300;

		function animate(){

			const x1 = amplitude * Math.sin(frequency * time);
			const y1 = radius * Math.cos(angle + Math.PI * 1.5);

			const x2 = amplitude * Math.sin(frequency * time + Math.PI * 2.6);
			const y2 = radius * Math.cos(angle + Math.PI * 0.5);

			const x3 = amplitude * Math.sin(frequency * time + Math.PI * 1.7);
			const y3 = radius * Math.cos(angle + Math.PI * 0.7);

			const x4 = amplitude * Math.sin(frequency * time + Math.PI * 3.4);
			const y4 = radius * Math.cos(angle + Math.PI * 1.2);

			const x5 = amplitude * Math.sin(frequency * time + Math.PI * 0.4);
			const y5 = radius * Math.cos(angle + Math.PI * 1.9);

			const x6 = amplitude * Math.sin(frequency * time + Math.PI * 2.9);
			const y6 = radius * Math.cos(angle + Math.PI * 0.9);

			circle1.style.transform = `translate(${-50 + x1}%, ${-50 + y1}%)`;
			circle2.style.transform = `translate(${-50 + x2}%, ${-50 + y2}%)`;
			circle3.style.transform = `translate(${-50 + x3}%, ${-50 + y3}%)`;
			circle4.style.transform = `translate(${-50 + x4}%, ${-50 + y4}%)`;
			circle5.style.transform = `translate(${-50 + x5}%, ${-50 + y5}%)`;
			circle6.style.transform = `translate(${-50 + x6}%, ${-50 + y6}%)`;

			time += 1;
			angle += 0.005;

			requestAnimationFrame(animate);
		}

		animate();

	</script>

	<div class="boxbox"></div>
	<div class="box">
		<div class="projects"></div>
		<div class="projects"></div>
		<div class="projects"></div>
		<div class="projects"></div>
		<div class="projects"></div>
		<div class="projects"></div>
		<div class="projects"></div>
		<div class="projects"></div>
		<div class="projects"></div>
	</div>
</body>

</html>