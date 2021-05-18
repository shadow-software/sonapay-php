<?php

namespace SonaPay\Entities;

interface EntityInterface
{
    public function create($params = [], $opts = []);
}