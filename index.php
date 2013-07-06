<?php $early = date('H') < 11; $late = date('H') > 18; ?>
<!DOCTYPE html>
<html lang="nl">
<head>
	<title>Tim's Mini Tour de France Site</title>
    <meta charset="utf-8" />
    
	<meta name="author" content="Tim Benniks" />
	<meta name="description" content="Volg de Tour de France live!" />
    <meta name="keywords" content="Live, Feed, Stream, Tour de France" />
	
	<meta property="og:title" content="Tim&#039;s Mini Tour de France Site" />
	<meta property="og:image" content="http://tdf.timbenniks.nl/logo.png" />
	<meta property="og:description" content="Volg de Tour de France live!" />
	<meta property="og:url" content="http://tdf.timbenniks.nl/" />
	
	<link rel="apple-touch-icon-precomposed" href="logo.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="logo.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="logo.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="logo.png" />
    <link rel="shortcut icon" href="logo.png" />

	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=1,minimum-scale=1,maximum-scale=1" />

	<link href="http://fonts.googleapis.com/css?family=Pathway+Gothic+One" rel="stylesheet" type="text/css" />
	<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	
	<img id="logo" width="140" src="logo.png" alt="logo" />
	
	<div class="stage-info"></div>
	
	<?php if(!$early && !$late) { ?>
	<ul class="gaps"></ul>
	<?php } ?>
	<ul class="comments"></ul>

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script>
		$(function()
		{
			window.liveComments = function(listTofill)
			{
				var items = [],
					firstCall = false,
					
				add = function(item)
				{
					if(!items[item.id])
					{
						items[item.id] = item;
						render(item);
					}
				},
			
				render = function(item)
				{
					var html = '<li id="'+ item.id +'"><strong>' +  item.date_created.substr(11, 5) + ' uur</strong><div class="content"><h2>' + item.title + '</h2>' + item.body + '</div></li>';
					
					if(firstCall)
					{
						listTofill.append(html);
					}
					else
					{
						listTofill.prepend(html);
					}
				},
			
				fetch = function(initial)
				{
					firstCall = initial;					
					
					$.ajax(
					{
						url: 'http://tdf.timbenniks.nl/comments.php',
						type: 'GET',
						dataType: 'jsonp'
					})
					.done(function(data)
					{
						if(data.error)
						{
							listTofill.html('<li><h2>Er is nog geen data voor deze etappe.</h2></li>');
						}
						else
						{						
							$.each(data, function()
							{
								add(this);
							});
						}							
						
						setTimeout(function(){ fetch(false) }, 30000);
					});
				};
			
				fetch(true);
			};
			
			window.stageInfo = function(stageInfoWrapper)
			{
				var populateInfo = function(data)
				{
					var kmremaining = data.kmremaining,
						averagespeed = data.averagespeed,
						currentspeed = data.currentspeed,
						currentdistance = data.currentdistance,
						distance = parseInt(data.distance, 10),
						progress = (currentdistance > 0) ? Math.round((currentdistance / distance) * 100) : 0,
						departure = data.departure,
						arrival = data.arrival;
		
					stageInfoWrapper
						.empty()
						.append('<h1>'+ departure +' &ndash; ' + arrival + '</h1>')
						.append('<dl><dd>Afstand</dd><dt>'+ distance +'km</dt><dd>Afgelegd</dd><dt>'+ currentdistance +'km</dt><dd>snelheid</dd><dt>'+ currentspeed+'km/u</dt><dd>gemiddeld</dd><dt>'+ averagespeed+'km/u</dt></dl>')
						.append('<div class="stage-img-wrapper"><img class="stage-img" src="http://app.nos.nl/tourscherm-2013/img/profielen/profiel-'+ data.stagenumber.substring(0, data.stagenumber.length - 2)+'.png" /><div class="progress" style="width:'+ progress +'%"></div></div>');
				},
			
				fetch = function()
				{
					$.ajax(
					{
						url: 'http://tdf.timbenniks.nl/position.php',
						type: 'GET',
						dataType: 'jsonp'
					})
					.done(function(data)
					{
						populateInfo(data);
						setTimeout(fetch, 30000);
					});
				};
			
				fetch();
			};
			
			window.liveGaps = function(listTofill)
			{
				var fetch = function(initial)
				{
					$.ajax(
					{
						url: 'http://tdf.timbenniks.nl/gaps.php',
						type: 'GET',
						dataType: 'jsonp'
					})
					.done(function(data)
					{
						listTofill.empty();
						
						$.each(data, function()
						{
							listTofill.prepend(this.gaphtml);
						});
												
						setTimeout(function(){ fetch(false) }, 30000);
					});
				};
			
				if(listTofill.length)
				{
					fetch(true);
				}
			};
			
			new liveGaps($('.gaps'));
			new liveComments($('.comments'));
			new stageInfo($('.stage-info'));
		});
	</script>
	
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-42229496-1', 'timbenniks.nl');
		ga('send', 'pageview');
	</script>

</body>
</html>