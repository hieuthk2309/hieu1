<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Http\FormRequest;

abstract class Controller
{
	public abstract function index();
	public abstract function store(FormRequest $request);
	public abstract function update(FormRequest $request, int $id);
	public abstract function show(int $id);
	public abstract function destroy(int $id);

}
