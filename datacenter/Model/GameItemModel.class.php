<?php
/**
 * 游戏物品操作类
 * Class GameItem
 */
class GameItemModel extends BasicModel
{
 
    /**
     *  添加物品
     * @param $name 物品名称
     * @param $type 物品类型
     * @param $game_plat 游戏平台
     */
    public function  addItem($name, $type, $game_plat)
    {
        $a = $this->_db->reset()->Table('t_item')->Fields('type', 'name', 'time', 'game_plat')->Record(array($name, $type, date("Y-m-d H:i:s"), $game_plat))->save();
        if ($a['affect_rows'] == 0) {
            return false;
        }
    }


    /**
     * 更新物品
     * @param array $update_fields 更新的字段数组
     * @param null $item_id 物品id
     * @return bool
     */
    public function  updateItem(array $update_fields, $item_id = null)
    {
        $a = $this->_db->reset()->Table('t_item')->where('id = ' . (int)$item_id)->Fields(array_keys($update_fields))->Record(array_values($update_fields))->update();
        if ($a['affect_rows'] == 0) {
            return false;
        }
    }

    /**
     *  删除物品
     * @param $id 物品id
     */
    public function  delItem($id)
    {
        $this->_db->reset()->Table('t_item')->Where("id = " . (int)$id)->delete();
    }

    /**
     * 获取游戏物品列表
     * @param $game_plat 游戏平台id
     */
    public function  getGameItem($game_plat)
    {
        $data = $this->_db->reset()->Table('t_item')->Where("game_plat = " . $game_plat)->FetchAll();;
        return $data;
    }
}