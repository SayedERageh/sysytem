<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>نظام الواجهة الخيالي</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Scheherazade+New&display=swap" rel="stylesheet">
<style>
  body {
    margin: 0;
    padding: 0;
    font-family: 'Scheherazade New', serif;
    overflow: hidden;
    background: radial-gradient(ellipse at center, #0d0d0d 0%, #1a1a1a 100%);
  }
  #spaceCanvas {
    position: absolute;
    top: 0;
    left: 0;
  }
  section {
    position: relative;
    z-index: 10;
  }
  .glow-btn {
    box-shadow: 0 0 20px rgba(255,255,255,0.2);
    transition: all 0.4s ease-in-out;
  }
  .glow-btn:hover {
    box-shadow: 0 0 60px rgba(255,255,255,0.6), 0 0 80px rgba(128,0,255,0.5);
    transform: scale(1.15) rotate(-2deg);
  }
</style>
</head>
<body>

<canvas id="spaceCanvas"></canvas>

<section class="h-screen flex flex-col items-center justify-center text-center text-white p-10">
  <h1 class="text-6xl md:text-7xl font-bold mb-6 animate__animated animate__fadeInDown animate__slow drop-shadow-lg">
    مرحباً بك في نظام الواجــهـــة 
  </h1>
  <p class="text-2xl mb-10 animate__animated animate__fadeInUp animate__delay-1s drop-shadow-lg">
    استعد لتجربة نظام فريدة، اضغط على الزر للدخول
  </p>
  <a href="/admin" class="glow-btn px-12 py-5 text-2xl font-bold text-purple-400 bg-white bg-opacity-20 rounded-full backdrop-blur-lg 
     hover:bg-purple-600 hover:text-white animate__animated animate__pulse animate__infinite">
    اذهب إلى النظام هنا
  </a>
</section>

<script>
const canvas = document.getElementById('spaceCanvas');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

// نجوم متحركة
let stars = [];
for(let i=0;i<400;i++){
  stars.push({
    x: Math.random()*canvas.width,
    y: Math.random()*canvas.height,
    r: Math.random()*1.5,
    dx: (Math.random()-0.5)*0.5,
    dy: (Math.random()-0.5)*0.5
  });
}

// هالات ضوئية
let glows = [];
for(let i=0;i<50;i++){
  glows.push({
    x: Math.random()*canvas.width,
    y: Math.random()*canvas.height,
    r: Math.random()*100+50,
    color: `hsla(${Math.random()*360},100%,70%,0.2)`,
    dx: (Math.random()-0.5)*0.3,
    dy: (Math.random()-0.5)*0.3
  });
}

function draw(){
  ctx.clearRect(0,0,canvas.width,canvas.height);
  
  // الخلفية السوداء مع تأثير خفيف
  ctx.fillStyle = 'rgba(0,0,0,0.1)';
  ctx.fillRect(0,0,canvas.width,canvas.height);

  // رسم النجوم
  stars.forEach(s=>{
    ctx.beginPath();
    ctx.arc(s.x, s.y, s.r, 0, Math.PI*2);
    ctx.fillStyle = 'white';
    ctx.fill();
    s.x += s.dx;
    s.y += s.dy;
    if(s.x <0) s.x=canvas.width;
    if(s.x>canvas.width) s.x=0;
    if(s.y<0) s.y=canvas.height;
    if(s.y>canvas.height) s.y=0;
  });

  // رسم الهالات
  glows.forEach(g=>{
    let grd = ctx.createRadialGradient(g.x,g.y,0,g.x,g.y,g.r);
    grd.addColorStop(0,g.color);
    grd.addColorStop(1,'transparent');
    ctx.fillStyle = grd;
    ctx.beginPath();
    ctx.arc(g.x,g.y,g.r,0,Math.PI*2);
    ctx.fill();
    g.x += g.dx;
    g.y += g.dy;
    if(g.x <0) g.x=canvas.width;
    if(g.x>canvas.width) g.x=0;
    if(g.y<0) g.y=canvas.height;
    if(g.y>canvas.height) g.y=0;
  });

  requestAnimationFrame(draw);
}

draw();

window.addEventListener('resize', ()=>{
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
});
</script>

</body>
</html>
