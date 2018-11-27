<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Ihelpers\Http\Controllers\BaseApiController;
use Modules\Iprofile\Entities\Customfield;
use Modules\Iprofile\Http\Requests\CreateCustomfieldRequest;
use Modules\Iprofile\Http\Requests\UpdateCustomfieldRequest;
use Modules\Iprofile\Repositories\CustomfieldRepository;
use Modules\Iprofile\Transformers\CustomFieldTransformer;

class CustomfieldController extends BaseApiController
{
    /**
     * @var CustomfieldRepository
     */
    private $customfield;

    public function __construct(CustomfieldRepository $customfield)
    {
        parent::__construct();

        $this->customfield = $customfield;
    }


    public function index(Request $request)
    {

        try {
            $p = $this->parametersUrl(1, 12, false, []);

            //Request to Repository
            $results = $this->customfield->whereFilters($p->page, $p->take, $p->filter, $p->include);

            //Response
            $response = ["meta" => [], "data" => CustomFieldTransformer::collection($results)];

            //If request pagination add meta-page
            $p->page ? $response["meta"] = ["page" => $this->pageTransformer($results)] : false;
        } catch (\Exception $e) {
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Error Query Custom Fields",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);

    }
    
    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */

    public function show($id, Request $request)
    {

        try {
           
            $field=$this->customfield->find($id);
            if (isset($field)) {

                $response = [
                    'type' => 'item',
                    'id' => $field->id,
                    'data' => new CustomFieldTransformer($field),
                ];

            } else {
                $status = 404;
                $response = ['errors' => [
                    "code" => "404",
                    "source" => [
                        "pointer" => url($request->path()),
                    ],
                    "title" => "Not Fount",
                    "detail" => "The field not fount"
                ]
                ];
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Value is too short",
                "detail" => "First name must contain at least three characters."
            ]
            ];
        }
        return response()->json($response, $status ?? 200);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try {
            
            $customfield = $this->customfield->create($request->all());
            $response = [
                'success' => [
                    'code' => '200',
                    'source' => [
                        'pointer' => url($request->path())
                    ],
                    "title" => trans('core::core.messages.resource created', ['name' => trans('iprofile::customfields.title.customfields')]),
                    "detail" => [
                        'id' => $customfield->id
                    ]
                ]
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Value is too short",
                "detail" => "First name must contain at least three characters."
            ]
            ];
        }


        return response()->json($response, $status ?? 200);

    }

    /**
     * @param Customfield $customfield
     * @param IblogRequest $request
     * @return mixed
     */
    public function update(Customfield $customfield, CustomfieldRequest $request)
    {

        try {

            if (isset($customfield->id) && !empty($customfield->id)) {

                $customfield = $this->customfield->update($customfield, $request->all());

                $status = 200;
                $response = [
                    'susses' => [
                        'code' => '201',
                        "source" => [
                            "pointer" => url($request->path())
                        ],
                        "title" => trans('core::core.messages.resource updated', ['name' => trans('iprofile::customfields.singular')]),
                        "detail" => [
                            'id' => $customfield->id
                        ]
                    ]
                ];


            } else {
                $status = 404;
                $response = ['errors' => [
                    "code" => "404",
                    "source" => [
                        "pointer" => url($request->path()),
                    ],
                    "title" => "Not Found",
                    "detail" => 'Query empty'
                ]
                ];
            }
        } catch (\Exception $e) {
            Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Error Query Customfield",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * @param Customfield $customfield
     * @param Request $request
     * @return mixed
     */
    public function delete(Customfield $customfield, Request $request)
    {
        try {
            $this->customfield->destroy($customfield);
            $status = 200;
            $response = [
                'susses' => [
                    'code' => '201',
                    "title" => trans('core::core.messages.resource deleted', ['name' => trans('iprofile::customfields.singular')]),
                    "detail" => [
                        'id' => $customfield->id
                    ]
                ]
            ];

        } catch (\Exception $e) {
            Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Error Query Customfield",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }
}
