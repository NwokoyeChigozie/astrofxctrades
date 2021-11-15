$(document).ready(function () {
  const line = Array.from($(".lineAbout"));
  for (i = 0; i < line.length; i++) {
    drawline(line[i]);
  }


  
  var scrollMagicControl = new ScrollMagic.Controller();
  var scene = new ScrollMagic.Scene({ triggerElement: ".about-features",reverse: false})
										.on("enter", function () {
                      myTimeline.add({
                        targets: ".about-features__item.services",
                        opacity:[0,1],
                        easing: 'easeInOutSine',
                        duration: 500,
                        offset:0
                      }).add({
                        targets: ".about-features__item.security",
                        opacity:[0,1],
                        easing: 'easeInOutSine',
                        duration: 500,
                        offset:300
                      })
                      .add({
                        targets: ".about-features__item.guid",
                        opacity:[0,1],
                        easing: 'easeInOutSine',
                        duration: 500,
                        offset:600
                      })
										})
                    .addTo(scrollMagicControl);

                   // scrollMagicControl.destroy(true);
                    
  // var scrollMagicControl = new ScrollMagic.Controller();

  // var scene = new ScrollMagic.Scene({
  //   offset: 900 
  // })
  // .setTween(myTimeline)
  // .addTo(scrollMagicControl);


})
var offset = 0;

function drawline(l) {
  offset += 10;
  anime({
    targets: l,
    strokeDashoffset: [anime.setDashoffset, 1],
    easing: 'easeInOutSine',
    duration: 500,
    offset: offset
  })
}

var myTimeline = anime.timeline();

 