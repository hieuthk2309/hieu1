<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Repositories\ProductRepository;
use App\Validators\ProductValidator;
use Illuminate\Http\RedirectResponse;

/**
 * Class PostsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ProductController extends Controller
{
	/**
	 * @var ProductRepository
	 */
	protected $repository;

	/**
	 * @var ProductValidator
	 */
	protected $validator;

	public function __construct(ProductRepository $repository, ProductValidator $validator)
	{
		$this->repository = $repository;
		$this->validator = $validator;
	}

	public function index()
	{
		$this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
		$posts = $this->repository->all();

		if (request()->wantsJson()) {

			return response()->json([
				'data' => $posts,
			]);
		}

		return view('posts.index', compact('posts'));
	}

	public function store(FormRequest $request)
	{
		try {

			$this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

			$post = $this->repository->create($request->all());

			$response = [
				'message' => 'Post created.',
				'data' => $post->toArray(),
			];

			if ($request->wantsJson()) {

				return response()->json($response);
			}

			return redirect()->back()->with('message', $response['message']);
		} catch (ValidatorException $e) {
			if ($request->wantsJson()) {
				return response()->json([
					'error' => true,
					'message' => $e->getMessageBag()
				]);
			}

			return redirect()->back()->withErrors($e->getMessageBag())->withInput();
		}
	}

	public function show(int $id)
	{
		$post = $this->repository->find($id);

		if (request()->wantsJson()) {

			return response()->json([
				'data' => $post,
			]);
		}

		return view('posts.show', compact('post'));
	}

	public function edit($id)
	{
		$post = $this->repository->find($id);

		return view('posts.edit', compact('post'));
	}

	public function update(FormRequest $request, int $id)
	{
		try {

			$this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

			$post = $this->repository->update($request->all(), $id);

			$response = [
				'message' => 'Post updated.',
				'data' => $post->toArray(),
			];

			if ($request->wantsJson()) {

				return response()->json($response);
			}

			return redirect()->back()->with('message', $response['message']);
		} catch (ValidatorException $e) {

			if ($request->wantsJson()) {

				return response()->json([
					'error' => true,
					'message' => $e->getMessageBag()
				]);
			}

			return redirect()->back()->withErrors($e->getMessageBag())->withInput();
		}
	}

	public function destroy(int $id)
	{
		$deleted = $this->repository->delete($id);

		if (request()->wantsJson()) {

			return response()->json([
				'message' => 'Post deleted.',
				'deleted' => $deleted,
			]);
		}

		return redirect()->back()->with('message', 'Post deleted.');
	}
}
