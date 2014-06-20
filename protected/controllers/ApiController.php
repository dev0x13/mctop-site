<?php

class ApiController extends Controller
{

    public function actionGetServer($id)
    {
        HApi::getServer($id);
    }

}