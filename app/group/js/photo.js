$(function(){

var $container = $('#container');

$.get(siteUrl+'index.php?app=group&ac=photo&ik=ajax', {  },
function(data){
	
	$container.html(data);
	
	$container.imagesLoaded(function(){
	  $container.masonry({
		itemSelector: '.card-item',
		columnWidth: 0
	  });
	});
	
});

$container.infinitescroll({
  navSelector  : '#page-nav',    // selector for the paged navigation 
  nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
  itemSelector : '.card-item',     // selector for all items you'll retrieve
  loading: {
	  finishedMsg: '没有内容可以加载啦！',
	  img: siteUrl+'public/images/loadingg.gif'
	}
  },
  // trigger Masonry as a callback
  function( newElements ) {
	// hide new items while they are loading
	var $newElems = $( newElements ).css({ opacity: 0 });
	// ensure that images load before adding to masonry layout
	$newElems.imagesLoaded(function(){
	  // show elems now they're ready
	  $newElems.animate({ opacity: 1 });
	  $container.masonry( 'appended', $newElems, true ); 
	  
	  $container.masonry({
		itemSelector: '.card-item',
		columnWidth: 0
	  });
	  
	});
  }
);

});