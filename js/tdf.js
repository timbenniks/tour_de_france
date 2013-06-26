function tdf($scope, $http)
{
	$scope.news = [];

	$scope.addTodo = function()
	{
		$scope.todos.push( {text: $scope.todoText });
	};

	var poll = function()
	{
		$http
			.jsonp("http://tdf.timbenniks.nl?callback=JSON_CALLBACK")
			.success(function(data)
			{
				angular.forEach(data.report, function(item)
				{
					this.push({published_at: item.published_at, title: item.title, comment: item.comment});

				}, $scope.news);
			});
	};

	setInterval(poll, 5000);
	poll();
}