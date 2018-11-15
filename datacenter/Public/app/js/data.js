var tmpArr1 = [
	[89.26, 296.38, 157.56, 105.80, 279.87, 165.67, 120.27],
	[1128, 1391, 1337, 1409, 1755, 1885, 1527],
	[9445, 17379, 15487, 14302, 19664, 17663, 13005]
];



var tmpArr2 = [
	[247551, 250368, 264347, 255622, 253579, 269293, 299139],
	[38034, 37874, 45253, 40243, 32475, 49957, 76155],
	[113884, 115574, 117040, 113628, 110067, 111811, 119044],
	[56094, 62098, 79854, 53978, 46983, 73498, 94567]
];

var tmpArr3 = [
	[81.4]
];

var tmpArr4 = [
	[24.3, 16.4, 12.6, 18.9, 23.3, 20.1, 23.0, 10.3, 14.5, 20.9, 13.2, 23.6, 17.7, 14.1, 12.9, 13.9, 23.1, 16.8, 18.0, 17.5, 23.0, 17.1, 17.4, 13.7, 22.8, 20.9, 23.6, 24.1, 11.9, 10.7],
	[11.8, 8.5, 17.9, 16.4, 9.3, 17.4, 15.7, 13.6, 13.1, 10.2, 16.2, 18.2, 19.5, 12.5, 13.4, 15.7, 12.6, 14.6, 12.4, 15, 16.9, 8.4, 10.8, 12.8, 10.3, 14.1, 18.7, 15.5, 15.1, 14.3],
	[9, 8.8, 9.7, 14.3, 10, 7.2, 8.2, 9.3, 10.1, 7.7, 5.1, 5.1, 5.2, 11.9, 9.1],
	[6.8, 5.2, 4.9, 5.6, 6.2, 7.1, 5.7],
	[6.8, 6.7]
];

var tmpArr5 = [
	[
		['骑兵系统', 605271],
		['坐骑系统', 274093],
		['银贯', 245538],
		['银贯钱庄', 125120],
		['团购活动', 98087],
		['日常消耗', 75090],
		['活动抽奖', 65677],
		['VIP系统', 51649],
		['四灵系统', 46398],
		['宝石系统', 24607]
	]
];

var tmpArr6 = [3482079, 9871087, 739423, 662369];
var tmpArr7 = [339, 8652205, 19794692];


// 测试模拟数据
var testTools = {};

testTools.randomNum = function(max, min, fixed) {
	var _max = max;
	if (!_max) {
		return false
	};
	var _min = min || 0;
	var _fixed = fixed || 0;
	var result = Math.random() * (_max - _min + 1) + _min;
	var resultStr = result.toFixed(fixed);
	return Number(resultStr);
}

testTools.randomArr = function(count, max, min, fixed) {
	var _max = max,
		_count = count;
	if (!_max || !_count) {
		return false
	};
	var _min = min || 0;
	var _fixed = fixed || 0;
	var result = [];
	for (var i = 0; i < _count; i++) {
		var num = this.randomNum(_max, _min, _fixed);
		result.push(num);
	}
	return result;
}

testTools.randomArrGroup = function(count, argsArr){
	var result= []
	for(var i=0; i<argsArr.length; i++){
		var tmp = this.randomArr(count, argsArr[i][0], argsArr[i][1], argsArr[i][2]);
		result.push(tmp);
	}
	return result;
}

testTools.rc_Args = [
	[300, 120, 2],
	[3000, 1000, 0],
	[10000, 7000, 0]
];

testTools.rc_Args2 = [
	[300000, 200000, 0],
	[80000, 30000, 0],
	[150000, 100000, 0],
	[100000, 40000, 0]
];