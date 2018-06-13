$(document).ready(function(){
          var flag = 0;
        $(document).on('click','.videoClass',function(){
          if (flag == 1) {
              $(".youtubeplay").empty();
          }

          var uniqueId = $(this).data("id");
          var youtubeEmbed = $(this).data("youtube_embed");
          flag = 1;
          $("#loderDiv").show().delay(1000).fadeOut(1000);
          setTimeout(function(){
                     $(".youtubeplay").append(youtubeEmbed);
                    }, 2000);

          $(".youtubeplay").show();
          
          
          
          $('html, body').animate({
          scrollTop: $('#loderDiv').offset().top-30
          }, 800, function(){
          });
          
        });
        
        $("#faqbutid").click(function(){
          
           $('html, body').animate({
          scrollTop: $('#faqsecid').offset().top-5
          }, 800, function(){
          });         
          
          });
        
        $("#helpbutid").click(function(){
          
           $('html, body').animate({
          scrollTop: $('.helpsecid').offset().top-5
          }, 800, function(){
          });         
          
          }); 
        
        $("#contact_support").click(function(){
           $('html, body').animate({
          scrollTop: $('#contact_supportid').offset().top-5
          }, 800, function(){
          });         
          
          });
        
         $("#disputeurl").click(function(){
           $('html, body').animate({
          scrollTop: $('#disputeid').offset().top-5
          }, 800, function(){
          });         
          
          });
        
        
});