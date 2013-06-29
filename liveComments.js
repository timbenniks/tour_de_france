window.liveComments = function(listTofill)
{
	var items = [],

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
		listTofill.append('<li id="'+ item.id +'"><strong>' +  item.date_created.substr(11, 5) + ' uur</strong><div class="content"><h2>' + item.title + '</h2>' + item.body + '</div></li>');
	},

	fetch = function()
	{
		$.ajax(
		{
			url: 'http://tdf.timbenniks.nl/comments.php',
			type: 'GET',
			dataType: 'jsonp'
		})
		.done(function(data)
		{
			$.each(data, function()
			{
				add(this);
			});

			setTimeout(fetch, 5000);
		});
	};

	fetch();
};