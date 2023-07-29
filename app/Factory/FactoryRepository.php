<?php

    namespace  App\Factory;

    use Illuminate\Database\Eloquent\Model;

    class FactoryRepository implements FactoryRepositoryInterface {

        protected Model $model;

        public function __construct(Model $model){
            $this->model = $model;
        }

        public function all(array $params = []){
            $query = $this->model->query();

            if (isset($params['orderBy'])) {
                $orderBy = explode(':', $params['orderBy']);
                $query->orderBy($orderBy[0], $orderBy[1] ?? 'asc');
            }

            if (isset($params['where'])) {
                foreach($params['where'] as $where) {
                    $where = explode(':', $where);
                    $query->where($where[0], $where[1]);
                }
            }

            if (isset($params['orWhere'])) {
                foreach($params['orWhere'] as $orWhere) {
                    $orWhere = explode(':', $orWhere);
                    $query->orWhere($orWhere[0], $orWhere[1]);
                }
            }

            if (isset($params['perPage'])) {
                return $query->paginate($params['perPage'] ?? 10);
            }

            return $query->get();
        }

        public function create(array $modelDto) : Model {
            return $this->model->create($modelDto);
        }

        public function find(array $attributes) : Model  {
            return $this->model->where($attributes)->first();
        }

        public function update(array $attributes, array $values = []) : Model | bool {
            $exist = $this->exist($attributes);
            if(!$exist) return false;
            return $exist->update(array_merge($attributes, $values));
        }

        public function exist(array $attributes) : Model | null {
            return $this->model->where($attributes)->first();
        }

        public function delete(array $attributes) : bool {
            $exist = $this->exist($attributes);
            if(!$exist) return false;
            return $exist->destroy($attributes);
        }
    }
