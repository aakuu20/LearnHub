 
 var playing = false;
 var score ;
 var action;
 var timeRemaining;
 var multiplication;
 var highScore = 80;

 document.getElementById("start").onclick=
 function(){

    if(playing == true){
        location.reload();
        document.getElementById("score")
    } 
    else{  

        playing = true;
       score = 0;
       document.getElementById("scorevalue").innerHTML = "Score: "+score;
     show("time");
     timeRemaining =60;
     document.getElementById("timecount").innerHTML ="Time remaining: " +timeRemaining+" sec";
     hide("gameOver");
  document.getElementById("start").innerHTML ="Reset Game";
    
    
    startCountdown();

    getQA();
    }
 }
 for(var i=1; i<5; i++){
   document.getElementById("box"+i).onclick=
   function(){
       if(playing==true){
           if(this.innerHTML==multiplication){
               score++;
               document.getElementById("scorevalue").innerHTML="Score: "+score;
           hide("wrong");
           show("correct");
           setTimeout(function(){
               hide("correct");
           }, 1000);
           getQA();
            }else{
                show("wrong");
                hide("correct");
                setTimeout(function(){
                    hide("wrong");
                }, 1000);
            }
       }
   }
 }

 function startCountdown(){
     action = setInterval(function(){ 
       timeRemaining -=1;
       document.getElementById("timecount").innerHTML ="Time remaining: " +timeRemaining+" sec";
       if(timeRemaining == 0){
          stopCountDown();
          show("gameOver");
          if(score>highScore){
            document.getElementById("gameOver").innerHTML = "<p>Game over!</p><p>!!!congratulations!!!</p><p>You scored highest,your score is: "+score+"</p>";
            document.getElementById("highScore").innerHTML="Highest Score: "+score;  
        }else{
       document.getElementById("gameOver").innerHTML = "<p>Game over!</p><p>Your score is: "+score+"</p>";
          }
          hide("time");
       hide("wrong");
       hide("correct");
       playing =false;
       document.getElementById("start").innerHTML="Start Game";
        } 
    },1000)
 }

 function stopCountDown(){
     clearInterval(action);
 }

 function show(id){
   document.getElementById(id).style.display = "block";
 }

 function hide(id){
document.getElementById(id).style.display="none";
 }

 function getQA(){
     var x = 1+ Math.round(9*Math.random());
     var y = 1+ Math.round(9*Math.random());
     multiplication =x*y;

     document.getElementById("luci").innerHTML= x+" x "+y;
     var correctPosition =1+ Math.round(3*Math.random());
         document.getElementById("box"+correctPosition).innerHTML = multiplication;
         
         for(var i=1; i<5 ;i++){
            if(i !=correctPosition){
                var wrongAnswer = 1+ Math.round(99*Math.random());
                if(wrongAnswer !=multiplication){
                document.getElementById("box"+i).innerHTML =wrongAnswer ;
            }else{
                wrongAnswer = 1+ Math.round(100*Math.random());
            }
               }
        }
        }

    