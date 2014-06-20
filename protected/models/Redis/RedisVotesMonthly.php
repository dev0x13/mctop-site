<?php

    class RedisVotesMonthly extends RedisVotes
    {

        public function save($project)
        {
            $this->db = Yii::app()->votes_monthly->getClient();
            $this->id = hash('md2',date('d',time()).':project:'.$project.':user_id:'.Yii::app()->user->id);

            foreach ($this->get_data_in_array() as $key => $value)
                $this->db->hset($this->id, $key, $value);

            return $this->id;
        }

        private function get_data_in_array()
        {
            $keys = explode(':', $this->_values_to_save);
            foreach ($keys as $key) {
                $getter = 'get_' . $key;
                $data[$key] = call_user_func(get_called_class() . '::' . $getter);
            }
            return $data;
        }

    }