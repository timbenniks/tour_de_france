window.stageInfo = function(stageInfoWrapper)
{
	var populateInfo = function(data)
	{
		var kmremaining = data.kmremaining,
			averagespeed = data.averagespeed,
			currentspeed = data.currentspeed,
			distance = data.distance,
			kmelapsed = distance - kmremaining,
			progress = Math.round(kmelapsed / distance) * 100,
			departure = data.departure,
			arrival = data.arrival;

		stageInfoWrapper
			.empty()
			.append('<h1>'+ departure +' &ndash; ' + arrival + '</h1>')
			.append('<dl><dd>Total distance</dd><dt>'+ distance +'km</dt><dd>Elapsed</dd><dt>'+ kmelapsed +'km</dt><dd>Progress</dd><dt>'+ progress +'%</dt><dd>current speed</dd><dt>'+ currentspeed+'</dt><dd>Avarage speed</dd><dt>'+ averagespeed+'</dt></dl>')
			.append('<img class="stage-img" src="http://app.nos.nl/tourscherm-2013/img/profielen/profiel-'+ data.stagenumber.substring(0, data.stagenumber.length - 2)+'.png" />');
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
			setTimeout(fetch, 5000);
		});
	};

	fetch();
};