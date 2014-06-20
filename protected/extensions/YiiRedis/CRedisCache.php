<?php

/**
 * CRedisCache class file
 */
class CRedisCache extends CCache
{
    /**
     * Initializes this application component.
     * This method is required by the {@link IApplicationComponent} interface.
     * It creates the redis instance and adds redis servers.
     * @throws CException if redis extension is not loaded
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Retrieves a value from cache with a specified key.
     * This is the implementation of the method declared in the parent class.
     * @param string $key a unique key identifying the cached value
     * @return string the value stored in cache, false if the value is not in the cache or expired.
     */
    protected function getValue($key)
    {
        return Yii::app()->redisCache->get($key);
    }

    /**
     * Retrieves multiple values from cache with the specified keys.
     * @param array $keys a list of keys identifying the cached values
     * @return array a list of cached values indexed by the keys
     * @since 1.0.8
     */
    protected function getValues($keys)
    {
        return Yii::app()->redisCache->mget($keys);
    }

    /**
     * Stores a value identified by a key in cache.
     * This is the implementation of the method declared in the parent class.
     *
     * @param string $key the key identifying the value to be cached
     * @param string $value the value to be cached
     * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
     * @return boolean true if the value is successfully stored into cache, false otherwise
     */
    protected function setValue($key, $value, $expire)
    {
        if ($expire > 0)
            return Yii::app()->redisCache->setex($key, $expire, $value);
        else
            return Yii::app()->redisCache->set($key, $value);
    }

    /**
     * Stores a value identified by a key into cache if the cache does not contain this key.
     * This is the implementation of the method declared in the parent class.
     *
     * @param string $key the key identifying the value to be cached
     * @param string $value the value to be cached
     * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
     * @return boolean true if the value is successfully stored into cache, false otherwise
     */
    protected function addValue($key, $value, $expire)
    {
        if ($expire > 0) {
            if (Yii::app()->redisCache->setnx($key, $expire, $value))
                return Yii::app()->redisCache->expire($key, $expire);
            return false;
        } else
            return Yii::app()->redisCache->setnx($key, $value);
    }

    /**
     * Deletes a value with the specified key from cache
     * This is the implementation of the method declared in the parent class.
     * @param string $key the key of the value to be deleted
     * @return boolean if no error happens during deletion
     */
    protected function deleteValue($key)
    {
        return Yii::app()->redisCache->del($key);
    }

    /**
     * Deletes all values from cache.
     * This is the implementation of the method declared in the parent class.
     * @return boolean whether the flush operation was successful.
     * @since 1.1.5
     */
    protected function flushValues()
    {
        return Yii::app()->redisCache->flush();
    }

    /**
     * call unusual method
     * */
    public function __call($method, $args)
    {
        return call_user_func_array(array(Yii::app()->redisCache, $method), $args);
    }

    /**
     * Returns whether there is a cache entry with a specified key.
     * This method is required by the interface ArrayAccess.
     * @param string $id a key identifying the cached value
     * @return boolean
     */
    public function offsetExists($id)
    {
        return Yii::app()->redisCache->exists($id);
    }
}

