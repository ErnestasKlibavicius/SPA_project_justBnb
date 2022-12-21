<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookableReviewIndexResource;
use App\Models\Bookable;
use Illuminate\Http\Request;

class BookableReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Bookable reviews
     *
     * Get the bookable resource reviews
     *
     * @response status=200 {
     * "data": [
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 5,
     * "content": "Quo aut temporibus dolorem blanditiis. Eos voluptas reiciendis rerum corporis aut id. Perferendis velit rem dolorem soluta occaecati atque. Numquam voluptatem aut atque soluta qui voluptatibus dolore. Excepturi quis fugit sint eum."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 3,
     * "content": "Eos dolorum temporibus debitis non. Et ducimus quas neque eaque quasi eos. Rem quis ad consequatur illo non eos. Aperiam non voluptatibus vero eaque. Ipsam esse omnis sunt tempore molestias quia eius."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 5,
     * "content": "Qui labore voluptatem at ea cupiditate. Quam tenetur quas provident quae ut ullam non. Voluptatem officia hic enim qui eos est. Neque et earum rerum nostrum. Ab necessitatibus qui sint velit quaerat ipsam."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 4,
     * "content": "Sed nihil sed quia ratione voluptatum laborum sunt. Eveniet ullam incidunt doloribus et laboriosam excepturi corporis. Accusamus in ut incidunt corrupti. Et ut non distinctio dolore atque ipsam distinctio. Sed consequuntur et officiis repudiandae."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 1,
     * "content": "Dolor sint et dignissimos temporibus. Aperiam et sint commodi consequatur. Sunt repudiandae sit optio aliquam. Laboriosam repudiandae placeat enim id maiores atque. Necessitatibus aliquid nihil sequi pariatur eius dolor est."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 4,
     * "content": "Vel voluptatibus ipsum perferendis in ipsam est non aut. Voluptates cupiditate eaque aut. Et hic eos a illum occaecati minima voluptatem iste. Ea pariatur et nulla deserunt cumque hic. Sit neque voluptatum qui commodi quas id unde."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 4,
     * "content": "Voluptatibus eum eum quia vero rem sit. Consectetur corporis quos asperiores mollitia maiores voluptate sint. Ut ut ad voluptates exercitationem ut. Quia qui ipsa facilis consectetur perspiciatis. Sint maxime accusamus earum qui quasi provident placeat."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 3,
     * "content": "Provident consectetur iste voluptatem voluptas et. Non ut sequi ut. Voluptas iure quae sint fugit dignissimos odio dolor. Aut consectetur corporis aut enim laudantium quisquam. Velit explicabo ut necessitatibus saepe ut voluptatem quam eligendi."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 2,
     * "content": "Vitae dolorum et iusto quia quia. Aut sint expedita officiis. Est commodi ut ratione ex dolores delectus. Fuga a et odio eligendi voluptatem est corrupti. Voluptas facere repudiandae aliquam est enim dolorem vel aspernatur."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 1,
     * "content": "Dolores corporis quam dolor accusamus alias. Consequuntur eveniet dignissimos mollitia. Et voluptates a natus voluptas neque. Fugit dignissimos libero sed consequuntur et rerum dolorem sint. Iure numquam est quod voluptas."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 3,
     * "content": "Cum et esse consequatur consequuntur error. Est id qui sint illo. Et ut voluptas dignissimos repellat ea iusto dignissimos. Recusandae placeat fugit illo sunt cupiditate quasi. Et laborum debitis quia ut."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 3,
     * "content": "Ut qui officiis voluptatem dolores. Aliquam beatae laborum quia tempora. Sequi quod reprehenderit occaecati in. Beatae ut magni rerum ipsum non quos et rerum. Tenetur ut magnam provident dicta quia."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 5,
     * "content": "Fugiat voluptatem et ullam iste consequuntur autem doloribus. Velit sed esse dicta dolorem. Corporis repellendus odio et quae voluptatem ipsum dolores. Ipsam excepturi harum autem sit. Odit non ipsam inventore suscipit rerum."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 5,
     * "content": "Quia vero et necessitatibus perspiciatis ut distinctio. Iste ex voluptates ut tempore asperiores voluptas. Similique rerum laborum qui vero officiis. Rerum enim nesciunt porro consequatur ullam eos perferendis beatae. Nesciunt corrupti officiis vel aspernatur id saepe est."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 3,
     * "content": "Doloremque tenetur corrupti repellat aut. Saepe ut et fugit perferendis vero. Nihil ut laboriosam nisi mollitia earum reprehenderit. Voluptate modi temporibus totam impedit. Ratione ut voluptates id nihil id architecto."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 3,
     * "content": "Laboriosam nemo omnis ipsam cupiditate et qui explicabo. Inventore libero autem aut nostrum et officiis animi doloribus. Deserunt ratione ut tenetur impedit porro. Similique exercitationem enim rem quae laborum. Voluptatem ad repellendus dolor atque culpa."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 2,
     * "content": "Libero autem nam adipisci facilis sint nobis dolores maiores. Quae sit vitae itaque maiores deserunt at odio. Explicabo rerum ipsam quam quas odio quo officiis consectetur. Autem harum quaerat non in. Labore consequatur dolores explicabo qui quisquam et quia."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 1,
     * "content": "Cum quia asperiores perferendis molestias. Molestias repellendus voluptates architecto sed consequatur inventore. Iusto quam facilis et qui. Soluta quis ratione dolores delectus tempora. Fugit officia dolor placeat nesciunt sapiente nihil."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 4,
     * "content": "Quae reiciendis mollitia consequuntur fuga. Vitae rem molestiae quia. Laudantium tempora eos sunt explicabo. Esse ut placeat deserunt quia. Quis aut modi velit iure natus eligendi."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 3,
     * "content": "Eveniet non odio quos iusto. Impedit temporibus ad at et numquam dolores. Corporis aliquam ea itaque autem alias. Similique at est aut fugit debitis fugit nihil. Dolor et excepturi dolor vero laudantium sunt."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 4,
     * "content": "Odit autem enim error. Velit labore ex officia ea nostrum a quae. Qui veritatis dolorum perferendis qui dolor eum voluptas. Repudiandae quia amet autem quisquam. Esse explicabo sit mollitia assumenda."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 4,
     * "content": "Rerum dolore non et ad sit vel. Veritatis tempore praesentium a. Incidunt quibusdam et non voluptas rerum. Vel quidem rem distinctio minima ipsam. Excepturi neque provident officiis itaque."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 2,
     * "content": "Eligendi est qui quia aut quis. Dolor eum sit molestiae fugit reprehenderit. Magnam dolor et debitis ut aliquid. Occaecati doloribus non ut eos quis. Dolor suscipit facilis corrupti perferendis."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 3,
     * "content": "Non sint ab explicabo ipsa aliquid ad. Quas doloremque recusandae autem. Amet nihil sint reprehenderit numquam nisi. Similique id nihil quos id qui. Quia nihil labore numquam omnis reprehenderit."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 5,
     * "content": "Porro quis ipsum voluptatibus esse. Perferendis voluptas maiores quis vero dolor quibusdam dolores incidunt. Et veniam quae aut. Facilis et magni quia praesentium. Voluptas eligendi quisquam molestiae in quas consequatur."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 2,
     * "content": "Dicta atque et aut expedita. Optio quae qui dicta. Dolorem maxime aut iure earum nostrum blanditiis aut. Laborum nulla quia officia deserunt. Est mollitia facilis inventore esse veniam voluptatem consequatur."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 4,
     * "content": "Aspernatur sed ut sint modi vero et. Sunt dolorem aut commodi distinctio. Tempore error ea qui neque. Rerum consequuntur qui magni pariatur. Voluptates ea vitae et molestias repellat magni."
     * },
     * {
     * "created_at": "2022-12-15T19:44:55.000000Z",
     * "rating": 2,
     * "content": "Aperiam commodi doloremque tempore nisi molestiae voluptatem. Blanditiis id fuga et ut saepe. Ipsa totam voluptates aut optio ut omnis voluptas. Dolor voluptatibus quibusdam sapiente recusandae quia unde nihil. Nemo fuga aut ratione ut voluptas quae eaque."
     * }
     * ]
     * }
     *
     *
     * @response status=401 {
     * "message": "Unauthenticated"
     * }
     *
     * @group Bookable
     * @header Authorization: Bearer your_token
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        $bookable = Bookable::findOrFail($id);
        return BookableReviewIndexResource::collection(
            $bookable->reviews()->latest()->get()
        );
    }
}
