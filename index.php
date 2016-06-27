<!DOCTYPE html>
<html lang="en">
<head>
	<title>Blue Bite - Rotten Tomatoes Test</title>
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	
	<meta name="viewport" content="width=375">
</head>
<body>

<div id="vueApp">
	
	<div id="titles">
		<div id="titleLeft">
			<h1 class="In-Theaters">In Theaters</h1>
		</div>
		<div id="linkRight">
			<h2 class="View-More"><a href="{{ view_more }}" target="_blank" >View More</a></h1>
		</div>
		<div class="clear"></div>
		<h3 class="Top-Movies-This-Week">Top Movies This Week</h3>
	</div>
	
	<div id="slider" v-touch:swipeleft="onSwipeLeft" v-touch:swiperight="onSwipeRight">
		<input type="radio" v-model="picked" name="slider" id="slide{{ $index }}" value="{{ $index }}" selected="false" v-for="movie in movies">
		<div id="slides">
			<div id="overflow">
				<div class="inner">
					<article class="movie" v-for="movie in movies">
						<div class="copy">
							<h4 class="One-line-movie-title">{{ movie.title }}</h4>
							<p class="synopsis">{{ movie.synopsis | truncate '100'}}</p>
							<div class="stars">
								<img class="star" src="images/star.svg" v-if="movie.ratings.critics_score >= 0" />
								<img class="star" src="images/star.svg" v-if="movie.ratings.critics_score >= 20" />
								<img class="star" src="images/star.svg" v-if="movie.ratings.critics_score >= 40" />
								<img class="star" src="images/star.svg" v-if="movie.ratings.critics_score >= 60" />
								<img class="star" src="images/star.svg" v-if="movie.ratings.critics_score >= 80" />
							</div>
						</div>
						<div class="posterArea">
							<img v-bind:src="movie.posters.profile" />
						</div>
					</article>
				</div>
			</div>
		</div>
		<div id="pills">
			<label for="slide{{ $index }}" v-for="movie in movies"></label>
		</div>
	</div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/vue/1.0.25/vue.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/vue-resource/0.9.0/vue-resource.min.js"></script>
<script src="js/hammer.min.js"></script>
<script src="js/vue-touch.min.js"></script>

<script type="text/javascript">
<!--
	var MovieComp = Vue.extend({});
	
	var mc = new MovieComp({
		el: '#vueApp',
		data: {
			debug: true,
			limit: 5,
			movies: [],
			picked: "0",
			view_more: ""
		},
		ready: function() {
			var url = "http://api.rottentomatoes.com/api/public/v1.0/lists/movies/box_office.json?limit="+this.limit+"&country=us&apikey=6czx2pst57j3g47cvq9erte5";
			this.$http.jsonp(url).then(function(response) {
				var data = response.json();
				this.movies = data.movies;
				this.view_more = data.links.alternate;
			}, function(response) {
				console.error("Error with AJAX Request");
			});
		},
		filters: {
			truncate: function(string, value) {
				return (string.length > value) ? (string.substring(0, value).trim() + '...') : string;
			}
		},
		methods: {
			onSwipeLeft: function(evt){
				if(this.picked < this.limit-1){
					this.picked++;
				}else{
					this.picked = 0;
				}
			},
			onSwipeRight: function(evt){
				if(this.picked > 0){
					this.picked--;
				}else{
					this.picked = this.limit-1;
				}
			}
		}
	});	
//-->
</script>

</body>
</html>
