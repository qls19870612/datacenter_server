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