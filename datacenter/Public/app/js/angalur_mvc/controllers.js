var appController = angular.module('appController', []);
var navigationCtrl = angular.module('navigationCtrl', []);

appController.controller('appController', ['$scope', '$cookies',
	function appController($scope, $cookies) {
		$scope.navigationTpl = {
			name: 'navigation',
			url: 'partials/navigationTpl.html'
		};
		$cookies.currentGame = $cookies.currentGame || 'lzsg';
	}
]);


navigationCtrl.controller('navigationCtrl', ['$scope', '$cookies',
	function navigationCtrl($scope, $cookies) {
		$scope.prop = {
			title: '运营分析系统2'
		};
		$scope.gameList = [{
			title: '崩坏3',
			pageId: 'bhs'
		}, {
			title: '游戏1',
			pageId: 'asta'
		}, {
			title: '游戏2',
			pageId: 'devilian'
		}, {
			title: '游戏3',
			pageId: 'eos'
		}, {
			title: '游戏4',
			pageId: 'hon'
		}, {
			title: '游戏5',
			pageId: 'kritika'
		}, {
			title: '游戏6',
			pageId: 'sunonline'
		}];

		var gameListFormat = function(col, arr){
			var _arr = arr, result = [];
			for(var i=0; i<Math.ceil(_arr.length/col); i++){
				result[i] = [];
				for(var j=0; j<col; j++){
					if(_arr[i*col+j]){
						result[i].push(_arr[i*col+j]);
					}
				}
			}
			return result;
		}

		$scope.gameList_f = gameListFormat(3, $scope.gameList);

		$scope.show = function() {
			console.log($scope.gameList_f);
		};

		$scope.toggleGamelist = function(gameName) {
			$('#selectGame .selecter').popover({
		      html:true,
		      placement:'bottom',
		      trigger:'click',
		      title:'请选相应游戏的报表：',
		      content:$('#selectGamePopover').html()
		    })
		};

		$scope.navInit = function() {
			$('#selectGame .selecter').popover({
			     html:true,
			     placement:'bottom',
			     trigger:'click',
			     title:'请选相应游戏的报表：',
			     content:$('#selectGamePopover').html()
			   })
		}
	}
]);