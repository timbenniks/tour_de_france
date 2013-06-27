function tdf($scope, $http, $filter)
{
	$scope.news = [];

	var newsItems = [];

	$scope.addItem = function(item)
	{
		if(!newsItems[item.id])
		{
			newsItems[item.id] = { published_at: new Date(Date.parse(item.published_at)), title: item.title, comment: item.comment };
			$scope.news.push(newsItems[item.id]);
		}
	};

	var poll = function()
	{
		$http
			.jsonp("http://tdf.timbenniks.nl?callback=JSON_CALLBACK")
			.success(function(data)
			{
				angular.forEach(data.report, function(item)
				{
					$scope.addItem(item);
				}, $scope.news);
			});
	};

	//setInterval(poll, 5000);
	poll();
}