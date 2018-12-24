
SELECT   iWorldId, vOperate, iGoodsId,sum(iCount) AS iCount ,count(DISTINCT iRoleId) AS iUserNum,count(iCount) AS iNum
FROM    dbdiabloyylog.GoodsFlow
WHERE   iIdentifier=2
AND date BETWEEN '2018-12-13' and '2018-12-14'
AND plat = 'yy'
and dteventtime BETWEEN '2018-12-13 00:00:00' and '2018-12-13 23:59:59'
GROUP BY  iWorldId, vOperate, iGoodsId
