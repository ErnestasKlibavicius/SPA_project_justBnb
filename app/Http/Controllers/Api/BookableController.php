<?php

namespace App\Http\Controllers\Api;

use App\Models\Bookable;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableIndexResource;
use App\Http\Resources\BookableShowResource;

/**
 * @group Bookable
 *
 * Routes for managing the bookable resource
 *
 */
class BookableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Index
     *
     * Display a listing of all Bookings.
     *
     * @response status=200 {
     * "data": [
     * {
     * "id": 1,
     * "title": "Lemketown Cheap House",
     * "description": "Explicabo iure molestiae doloremque dolorem dolorum. Rerum quaerat odio eos. Quaerat molestiae aut ratione."
     * },
     * {
     * "id": 2,
     * "title": "Blickport Cheap House",
     * "description": "Id debitis amet commodi eaque. Repellendus accusamus libero provident quidem quis. Alias veniam vitae deleniti autem. Eligendi sed maiores quisquam assumenda repellendus."
     * },
     * {
     * "id": 3,
     * "title": "Brooksmouth Rooms",
     * "description": "Numquam aspernatur ut voluptatem incidunt. Voluptate ut neque et ad harum. Quia maxime suscipit corporis rerum omnis."
     * },
     * {
     * "id": 4,
     * "title": "Hannafort House",
     * "description": "Voluptas magni et iste omnis iusto mollitia. Sint ipsa fugit a sunt. Natus unde voluptatem sit omnis nulla."
     * },
     * {
     * "id": 5,
     * "title": "Gulgowskiside Luxury Rooms",
     * "description": "Maiores labore quibusdam praesentium consequatur perferendis et. Nisi esse ab aut velit officia. Sint molestiae id fugit. Pariatur commodi rerum cupiditate nobis saepe in expedita."
     * },
     * {
     * "id": 6,
     * "title": "Lockmanmouth Cheap House",
     * "description": "Ratione molestias deserunt non commodi praesentium. Est perspiciatis commodi est. Fuga doloribus voluptas nemo dolorem. Voluptatem aliquam aut non voluptatem quo enim voluptas."
     * },
     * {
     * "id": 7,
     * "title": "Branditown Fancy Rooms",
     * "description": "Porro adipisci consectetur voluptatem corrupti assumenda odit et. In sit est omnis iusto id. Omnis et ut aut aut eius. Magni asperiores quis expedita quia neque ut tenetur."
     * },
     * {
     * "id": 8,
     * "title": "Lindgrenville Cheap Rooms",
     * "description": "Eius ducimus sed in corrupti. Veniam impedit et aut neque voluptas. Mollitia omnis enim culpa ut cum aliquam."
     * },
     * {
     * "id": 9,
     * "title": "Christychester Fancy Rooms",
     * "description": "Quis vel voluptatem minus reiciendis. Facilis sunt officia consequuntur ut. Quia earum laboriosam debitis. Consectetur fuga et voluptas consequuntur saepe iusto."
     * },
     * {
     * "id": 10,
     * "title": "Andersonmouth House",
     * "description": "Et totam et libero. Ullam quae dolores est consequuntur doloremque sint. Optio reprehenderit neque modi error reiciendis impedit."
     * },
     * {
     * "id": 11,
     * "title": "Altenwerthhaven Villa",
     * "description": "Sed eligendi hic qui. A vitae natus et nam quia non molestiae."
     * },
     * {
     * "id": 12,
     * "title": "Blandamouth Luxury Villas",
     * "description": "Quo rem sint ea nemo rerum beatae. Veritatis rerum exercitationem fugit. Velit omnis nostrum nesciunt adipisci. Distinctio quia nihil iure recusandae velit similique animi."
     * },
     * {
     * "id": 13,
     * "title": "New Emelychester Rooms",
     * "description": "Neque aut ipsum magni voluptates. Reiciendis voluptas reprehenderit unde eum sed rerum vero. Et dolorem molestiae eum enim optio quia. Est autem numquam cum sunt est."
     * },
     * {
     * "id": 14,
     * "title": "Port Kianaberg Luxury Rooms",
     * "description": "Et rem deleniti ut inventore deserunt et quo. A similique nihil libero saepe. Suscipit expedita similique optio magni id et quia. Eos laboriosam quam ipsum officiis non."
     * },
     * {
     * "id": 15,
     * "title": "West Shirley Rooms",
     * "description": "Nostrum laudantium vel commodi aut molestias et. Expedita et numquam in eligendi. Sint pariatur voluptas nihil eaque voluptatem libero et."
     * },
     * {
     * "id": 16,
     * "title": "Lake Franz House",
     * "description": "Repudiandae esse dolorem voluptatem et ea maxime. Ullam est unde quibusdam architecto. Rem pariatur possimus modi eaque natus corrupti ut."
     * },
     * {
     * "id": 17,
     * "title": "Deckowburgh Villa",
     * "description": "Reiciendis et ipsa et nam inventore animi perspiciatis eveniet. Corrupti vel adipisci officia velit distinctio. Id porro sit quod porro cupiditate."
     * },
     * {
     * "id": 18,
     * "title": "Gleichnerfurt Luxury Villas",
     * "description": "Et temporibus qui quo qui nisi voluptatem. Blanditiis eligendi quasi rerum repellendus rerum. Repellendus sed non ea velit. Sunt doloribus necessitatibus quia est quia sapiente blanditiis sequi."
     * },
     * {
     * "id": 19,
     * "title": "Pascalechester Cheap Rooms",
     * "description": "Qui cumque perspiciatis voluptas. Quae aliquid harum sunt amet quam. Voluptatum id rerum ut eos quo cupiditate nihil. Provident quia quod cum culpa numquam minima aut."
     * },
     * {
     * "id": 20,
     * "title": "Boyleton Villa",
     * "description": "Aut non quis libero placeat rerum sit. Voluptatem harum quisquam doloribus eos. Qui dolores maiores fugiat architecto quaerat."
     * },
     * {
     * "id": 21,
     * "title": "South Patrickstad Luxury Rooms",
     * "description": "Doloremque in aut accusamus ab. Sint reprehenderit consequuntur possimus sed. Voluptas voluptatem commodi soluta qui maiores."
     * },
     * {
     * "id": 22,
     * "title": "East Julien Cheap House",
     * "description": "Voluptas et tempore aut mollitia quam. Ratione praesentium rerum quibusdam autem deleniti. Reprehenderit architecto exercitationem est qui quae inventore facere. Id sit ad occaecati tempora."
     * },
     * {
     * "id": 23,
     * "title": "Lake Angel Cheap House",
     * "description": "Quisquam corporis et consequatur nobis vitae odit est. Sit voluptatem molestias et sit nobis."
     * },
     * {
     * "id": 24,
     * "title": "Dachtown Luxury Rooms",
     * "description": "Et iusto soluta officia quis exercitationem perferendis. Ratione consequuntur quo eum mollitia et ratione repudiandae repellat. Consequatur ipsam error explicabo."
     * },
     * {
     * "id": 25,
     * "title": "North Melisashire House",
     * "description": "Vel corrupti possimus voluptates expedita sequi occaecati tenetur. Optio consequatur quia aperiam qui. Qui beatae numquam velit voluptatem. Eius aut cupiditate voluptate eum."
     * },
     * {
     * "id": 26,
     * "title": "Ignaciostad Luxury Rooms",
     * "description": "Sed voluptatibus accusamus sint at quia alias. Saepe omnis aut recusandae fuga. Laudantium qui aliquid veritatis a."
     * },
     * {
     * "id": 27,
     * "title": "Gradyberg Villa",
     * "description": "Non placeat et officia voluptas. Optio doloribus est dolorum quia. Quidem voluptatum aut excepturi quisquam."
     * },
     * {
     * "id": 28,
     * "title": "West Ashlymouth Cottage",
     * "description": "Quis et illo voluptatem ut. Voluptate dolor ea architecto omnis qui natus saepe. Tempore et nobis iste explicabo enim eius."
     * },
     * {
     * "id": 29,
     * "title": "Lake Conradchester House",
     * "description": "Consequatur dignissimos iusto rem hic sint neque. Assumenda sint officiis sit nostrum ea. Suscipit dolores vel quam culpa totam molestiae vero. Ut ut sed fugit."
     * },
     * {
     * "id": 30,
     * "title": "Port Bessie Cheap Rooms",
     * "description": "Veniam labore dolorum aliquid esse tenetur repellendus. Tenetur fugiat animi quia sapiente quisquam. Nemo pariatur dignissimos quia eum voluptatem sit iusto."
     * },
     * {
     * "id": 31,
     * "title": "Zakarymouth Cheap Rooms",
     * "description": "Corrupti doloremque cupiditate dolor aut. Explicabo assumenda rerum harum eveniet animi minima voluptatibus voluptatum. Ab rerum explicabo nam odio qui. Veniam culpa nulla omnis ab."
     * },
     * {
     * "id": 32,
     * "title": "Susanahaven Cheap House",
     * "description": "Maxime consequatur molestias placeat. Repellendus dolores explicabo dolor omnis quam nemo. Autem sunt accusamus voluptas consequatur sint quo consectetur."
     * },
     * {
     * "id": 33,
     * "title": "New Alexaneburgh Villa",
     * "description": "Porro molestias accusantium dolor dolore qui dolore. Sed et nisi voluptas ut est sunt. Pariatur quibusdam quisquam dolore. Quo nostrum est in sit."
     * },
     * {
     * "id": 34,
     * "title": "Benedictfurt Fancy Rooms",
     * "description": "Nemo dignissimos cumque facere dicta quis et alias. Itaque perferendis maxime voluptates et."
     * },
     * {
     * "id": 35,
     * "title": "Port Josiannetown Cheap Rooms",
     * "description": "Sint aspernatur alias corporis itaque ad cumque. Expedita nihil natus voluptate repudiandae. Et quasi culpa quia eaque placeat perferendis nobis."
     * },
     * {
     * "id": 36,
     * "title": "North Odaburgh House",
     * "description": "Ab tempora et sequi corporis sed. Earum ratione accusamus nam velit dolorem. Minus a delectus id et sequi ut."
     * },
     * {
     * "id": 37,
     * "title": "Idellland House",
     * "description": "Molestiae voluptatem quia quo quos id dolores maiores. A rerum aperiam reprehenderit atque rerum. Aut ea libero explicabo architecto deleniti recusandae sed. Ipsam nihil earum quo reiciendis quo ut."
     * },
     * {
     * "id": 38,
     * "title": "West Shane Cheap Rooms",
     * "description": "A unde veniam quia neque. Unde consequatur ab deserunt culpa. Laboriosam est esse dicta id ut."
     * },
     * {
     * "id": 40,
     * "title": "Isaiville Rooms",
     * "description": "In ab aut suscipit ratione nihil. Suscipit corporis quam autem qui fugit. Amet ex reiciendis sunt ea veritatis in."
     * },
     * {
     * "id": 41,
     * "title": "South Bessie Cheap Rooms",
     * "description": "Rerum ab explicabo consequuntur minima voluptas delectus. Dicta incidunt aut totam. Delectus natus quidem laborum ratione et minima."
     * },
     * {
     * "id": 42,
     * "title": "Bayershire Cheap House",
     * "description": "Cupiditate id sit iure dolorum a dolorum quis. Asperiores harum ratione quasi voluptates. Deleniti architecto expedita qui veniam. Aut nostrum harum laboriosam quos commodi sit quos ut."
     * },
     * {
     * "id": 43,
     * "title": "Ethelshire House",
     * "description": "Omnis qui praesentium modi aut eos minima id repudiandae. Consequuntur ut provident nobis aspernatur quod. Voluptatem rerum qui quia ullam et."
     * },
     * {
     * "id": 44,
     * "title": "Jadefurt Cottage",
     * "description": "Veritatis deserunt rem eum nisi. Sed ex velit aut sit in voluptatem veritatis nisi."
     * },
     * {
     * "id": 45,
     * "title": "Gradyburgh Cottage",
     * "description": "In laboriosam voluptates alias dolorum. Minima nulla aut eveniet quia dolore libero aut optio. Sit nulla quis eaque sit atque ea ut."
     * },
     * {
     * "id": 46,
     * "title": "Daishafurt Cheap Rooms",
     * "description": "Et blanditiis dolores et numquam sit pariatur. Necessitatibus minus sapiente sint numquam. Excepturi explicabo facilis eos eos similique."
     * },
     * {
     * "id": 47,
     * "title": "Jessside Cottage",
     * "description": "At voluptatum qui pariatur consequatur. Rerum et et est suscipit ipsum accusamus. Molestiae eligendi blanditiis pariatur perspiciatis recusandae amet. Aut ut vero expedita accusamus aut quas."
     * },
     * {
     * "id": 48,
     * "title": "East Daniella Fancy Rooms",
     * "description": "Dolor distinctio molestias eligendi qui provident repellendus. Consequatur voluptatum consequatur et eum qui. Quo ut optio asperiores ut iure."
     * },
     * {
     * "id": 49,
     * "title": "Faustinobury Fancy Rooms",
     * "description": "Aut voluptates minima non in. Quam dolore voluptatem totam quaerat rerum pariatur omnis."
     * },
     * {
     * "id": 50,
     * "title": "Rennerberg Rooms",
     * "description": "Aspernatur autem omnis inventore vel officiis temporibus neque est. Et vero rerum explicabo autem."
     * },
     * {
     * "id": 51,
     * "title": "East Albinburgh Luxury Villas",
     * "description": "Placeat atque aut voluptatibus cum praesentium tenetur natus eligendi. Provident velit quibusdam sunt vitae porro voluptates blanditiis. Et quia illo maiores blanditiis veritatis."
     * },
     * {
     * "id": 52,
     * "title": "Port Linwoodmouth Cottage",
     * "description": "Est ut et excepturi corrupti quia. Omnis nostrum saepe ut velit blanditiis fuga. A voluptatem amet aliquam animi asperiores. Aut rerum aut et rerum architecto."
     * },
     * {
     * "id": 53,
     * "title": "Uptontown House",
     * "description": "Ut nemo voluptas ducimus beatae dolor soluta id. Enim quisquam et unde facilis. Cum laboriosam perferendis id tenetur. Deserunt praesentium labore in et."
     * },
     * {
     * "id": 54,
     * "title": "Mayertmouth Fancy Rooms",
     * "description": "Autem aut rerum atque deserunt iure. Quia labore totam modi odio ipsum nam non ducimus."
     * },
     * {
     * "id": 55,
     * "title": "Kozeyshire Luxury Villas",
     * "description": "Praesentium assumenda incidunt sunt. Labore impedit et ut architecto iusto facilis voluptatem. Nobis nobis ut harum est soluta. Voluptatum fugit ut sint asperiores autem."
     * },
     * {
     * "id": 56,
     * "title": "Gerholdview Cottage",
     * "description": "Ratione ut quod molestiae. Illum maiores et vel ad quis non nostrum. Et unde eveniet blanditiis aut. Fugiat molestias eum voluptate earum et eveniet voluptas quisquam."
     * },
     * {
     * "id": 57,
     * "title": "Leuschkehaven Rooms",
     * "description": "Deserunt nesciunt dolorem animi cumque. Qui tenetur voluptas alias ut recusandae. Nesciunt incidunt consectetur labore consequatur. Impedit praesentium cupiditate qui velit consectetur natus odit."
     * },
     * {
     * "id": 58,
     * "title": "Darefurt Cottage",
     * "description": "Omnis ipsam ea dolor minima quisquam temporibus quas. Quos perspiciatis qui quo veritatis. Ut ea et quidem doloribus cupiditate rerum."
     * },
     * {
     * "id": 59,
     * "title": "Lake Emie Luxury Rooms",
     * "description": "Qui soluta autem sed. Nisi adipisci maxime ipsum voluptatem sapiente. Quisquam odio omnis fugiat. Sint facilis culpa non et ut laboriosam ratione."
     * },
     * {
     * "id": 60,
     * "title": "East Berthaside Rooms",
     * "description": "Laborum similique consequatur numquam ipsam non distinctio corrupti. Et numquam sit quas voluptatem. Quasi doloribus minus ipsam sequi cumque."
     * },
     * {
     * "id": 61,
     * "title": "Andersontown Cheap Rooms",
     * "description": "Sit vitae voluptas eius. Sint sint ut sunt id. Consequatur sint saepe dolorum sed ut sint. Dolores officia unde illo doloremque. Quasi ipsum et doloremque et."
     * },
     * {
     * "id": 62,
     * "title": "Cotystad Cheap House",
     * "description": "Occaecati minus iure eius voluptatem alias. Consequuntur dolore et earum qui. Temporibus nihil excepturi inventore aut blanditiis quod. Sunt eum labore dolore quae eaque corrupti accusantium."
     * },
     * {
     * "id": 63,
     * "title": "East Merlmouth Villa",
     * "description": "Dolor est aut quia unde non et qui. Aut magnam quae sit et praesentium et officiis ratione. Adipisci repellendus iure rerum dolorum officia ducimus quia ea."
     * },
     * {
     * "id": 64,
     * "title": "West Zachariah Villa",
     * "description": "Nisi officiis et voluptatem consectetur nulla quidem quo. Placeat voluptatum quod autem et distinctio doloribus similique sed."
     * },
     * {
     * "id": 65,
     * "title": "Jacobsontown Luxury Rooms",
     * "description": "Ipsa corrupti delectus sunt et provident. Rerum adipisci fugiat in et qui a. Quia aut possimus consequatur tempore."
     * },
     * {
     * "id": 66,
     * "title": "New Mazie Cheap Rooms",
     * "description": "Ut occaecati animi in sapiente nulla doloremque. Nostrum mollitia asperiores dolorem similique. Dignissimos non nulla aut ipsam eius omnis. Excepturi magni id ab omnis unde sit quibusdam."
     * },
     * {
     * "id": 67,
     * "title": "Kuhnmouth Villa",
     * "description": "Velit maxime quo vel dolorem. Ratione facere cupiditate ullam natus eius libero explicabo. Dolor rerum vel omnis aliquid."
     * },
     * {
     * "id": 68,
     * "title": "Kilbackberg Cottage",
     * "description": "Delectus ut vel qui facilis voluptates ut pariatur. Adipisci fugit officia dolores. Consequatur ut velit commodi veniam alias qui."
     * },
     * {
     * "id": 69,
     * "title": "South Joanny House",
     * "description": "Rerum quis repudiandae aut. Ut provident dolores consequatur qui exercitationem. Aliquid dolorum voluptatem blanditiis."
     * },
     * {
     * "id": 70,
     * "title": "East Ashlynn Rooms",
     * "description": "Cumque in est quis. Officia suscipit occaecati voluptatum placeat. Similique repellendus vero quos nisi minima ut."
     * },
     * {
     * "id": 71,
     * "title": "Orenville Luxury Villas",
     * "description": "Soluta corporis numquam ea praesentium dolor id. Est sint ad temporibus excepturi vitae ab nihil ad. Aut et praesentium incidunt dolor inventore accusamus ut."
     * },
     * {
     * "id": 72,
     * "title": "East Orpha Fancy Rooms",
     * "description": "Sint amet nisi itaque velit sint. Error perspiciatis est maxime id. Et quis ex est aperiam. Sunt repellat placeat possimus. Cum quidem omnis aliquam ipsa vitae fugiat magni."
     * },
     * {
     * "id": 73,
     * "title": "North Luciano Luxury Villas",
     * "description": "Quo qui aut nihil minima quibusdam dignissimos autem. Totam ut quo eaque quia sequi sint aut. Quia expedita magni itaque quae praesentium est totam."
     * },
     * {
     * "id": 74,
     * "title": "Kendallbury Luxury Rooms",
     * "description": "Et similique aliquam et id quia. Autem sit nesciunt sint aut sint incidunt. Non enim et eveniet delectus qui."
     * },
     * {
     * "id": 75,
     * "title": "O'Konchester Cheap House",
     * "description": "Qui animi laborum quia quia. Velit ullam quod aliquam velit accusamus. Laboriosam molestiae autem optio eaque doloribus quasi. Officiis culpa tempora dolores pariatur ducimus."
     * },
     * {
     * "id": 76,
     * "title": "North Marinaton House",
     * "description": "Doloremque fuga perferendis molestias culpa est. Quae magni nihil aliquid quaerat quis architecto. Rerum neque eius expedita et nemo."
     * },
     * {
     * "id": 77,
     * "title": "Hartmannhaven Cottage",
     * "description": "Exercitationem et vero suscipit accusantium sapiente. Ipsam ut sit sint minima perferendis omnis incidunt. Ut harum explicabo neque corporis et."
     * },
     * {
     * "id": 78,
     * "title": "Ceciliaborough Luxury Rooms",
     * "description": "Dolorum nihil consequuntur voluptatem eius esse accusamus tempora adipisci. Laborum velit amet nesciunt maiores aspernatur architecto."
     * },
     * {
     * "id": 79,
     * "title": "South Edd Cottage",
     * "description": "Et illum voluptatem sed adipisci. Sint tempore est id dolor nesciunt rem. Eos dolore nihil cumque quis occaecati dolor. Quia assumenda reiciendis molestiae assumenda sunt."
     * },
     * {
     * "id": 80,
     * "title": "Ethelynmouth Luxury Rooms",
     * "description": "Tempora magni quo doloribus soluta pariatur repudiandae. Ut et quo mollitia eligendi est ab. Ea enim ipsum exercitationem voluptatem."
     * },
     * {
     * "id": 81,
     * "title": "New Monserrate Luxury Villas",
     * "description": "Dicta repudiandae omnis voluptates odit est. Odio aut reprehenderit ut cum amet maiores beatae. Iure et aperiam aut maxime."
     * },
     * {
     * "id": 82,
     * "title": "East Frankie Luxury Villas",
     * "description": "Temporibus eos eveniet nostrum quia dolorem ut aut. Aliquid voluptatem non voluptates corporis accusamus expedita modi aut. Hic corrupti vel consequatur ipsa. Ut voluptatum corporis modi nemo."
     * },
     * {
     * "id": 83,
     * "title": "Bradtkeland Cheap House",
     * "description": "Eaque corrupti fuga distinctio. Itaque est qui non sapiente consequatur ratione eos. Ad at placeat culpa vel in. Aliquid qui quia non ipsum ut."
     * },
     * {
     * "id": 84,
     * "title": "Baumbachstad Cheap Rooms",
     * "description": "Omnis qui dolor deleniti sed. Qui nemo illo molestias quisquam totam numquam tenetur. Sint temporibus qui velit id accusantium. Illum sed et soluta enim nesciunt. At aliquid enim ut quod."
     * },
     * {
     * "id": 85,
     * "title": "Rosalindton Luxury Rooms",
     * "description": "Harum illo neque consequuntur et sequi non. Dolor illum cupiditate atque rerum unde omnis eos. Explicabo voluptas quia quo. Aliquam consequatur quibusdam nam architecto libero natus."
     * },
     * {
     * "id": 86,
     * "title": "Port Jane Luxury Villas",
     * "description": "Placeat qui eaque reprehenderit adipisci maiores ut. Totam quaerat itaque consequatur quis. Facere est omnis porro."
     * },
     * {
     * "id": 87,
     * "title": "Luismouth Cheap House",
     * "description": "Suscipit voluptatem nemo id. Sunt dolor repellendus rerum est aut a. Veniam aliquam qui est officia qui."
     * },
     * {
     * "id": 88,
     * "title": "Enaland Luxury Villas",
     * "description": "Autem dolore rerum excepturi aut iusto sed commodi. Nihil laborum corporis ratione dolore et qui et."
     * },
     * {
     * "id": 89,
     * "title": "Fadelland Luxury Rooms",
     * "description": "Fuga velit incidunt rerum sit ut enim. Eius adipisci similique hic soluta rerum officia. Id laudantium aliquid nihil temporibus tenetur et."
     * },
     * {
     * "id": 90,
     * "title": "East Jennyfer Cottage",
     * "description": "Maxime in dolorem repellat. Unde laboriosam sit quibusdam est totam iusto. Atque tempora omnis corrupti mollitia temporibus."
     * },
     * {
     * "id": 91,
     * "title": "Boehmbury Cheap House",
     * "description": "Et dignissimos omnis molestiae laudantium soluta. Corporis adipisci id magni enim alias. Perferendis voluptatem repellat ut."
     * },
     * {
     * "id": 92,
     * "title": "East Lourdesberg House",
     * "description": "Nihil suscipit commodi iure ipsa dolore enim ratione. Architecto in tempore voluptate quas dicta et. Fugiat est veniam non. Blanditiis voluptatem voluptas autem reiciendis qui vel."
     * },
     * {
     * "id": 93,
     * "title": "West Alainaburgh Cheap House",
     * "description": "Ipsam rerum quis voluptatibus vitae ab voluptatem. Nam sint quae itaque qui nisi eaque. Animi inventore est quisquam nihil. Repudiandae repellendus exercitationem aliquid esse quos vero eos."
     * },
     * {
     * "id": 94,
     * "title": "Port Michelview Fancy Rooms",
     * "description": "Cum iusto libero architecto officia sed mollitia. Assumenda quod nam neque incidunt rem. Veritatis qui ullam voluptatem."
     * },
     * {
     * "id": 95,
     * "title": "Alberthaville Luxury Villas",
     * "description": "Minus rerum quasi quod aut deleniti doloremque soluta. Recusandae ut quo molestiae. Exercitationem natus repellendus quaerat nulla. Officia ab ratione quia quod temporibus eius."
     * },
     * {
     * "id": 96,
     * "title": "Garrettshire Villa",
     * "description": "Impedit natus voluptate recusandae laboriosam nam. Voluptatem consequatur dolores ullam. Ad alias aut explicabo numquam natus explicabo ipsa."
     * },
     * {
     * "id": 97,
     * "title": "Abagailland Cheap House",
     * "description": "Aperiam distinctio doloremque laborum fuga quibusdam quod iusto. Ducimus perferendis ex eum repudiandae ut. Distinctio error necessitatibus vel reiciendis."
     * },
     * {
     * "id": 98,
     * "title": "Spinkaberg Cottage",
     * "description": "Recusandae et non odio amet assumenda. Est consequatur beatae iste labore libero. Earum corrupti voluptatibus atque dolore. Dignissimos facilis consectetur sint odio sed."
     * },
     * {
     * "id": 99,
     * "title": "Elmorestad Cheap Rooms",
     * "description": "Ducimus ullam ut eligendi blanditiis reprehenderit debitis. Ea qui dicta minus aperiam. Quae praesentium veritatis ad id."
     * },
     * {
     * "id": 100,
     * "title": "Swiftstad Cheap Rooms",
     * "description": "Nobis repellat repudiandae cumque unde officiis. Ex fugit eum suscipit id officiis exercitationem. Tenetur in corporis laborum voluptate dolores perferendis ratione iste."
     * },
     * {
     * "id": 101,
     * "title": "testas 123",
     * "description": "super test"
     * },
     * {
     * "id": 102,
     * "title": "testasssss",
     * "description": "adsdas"
     * },
     * {
     * "id": 106,
     * "title": "asddasdas",
     * "description": "asddasasd"
     * }
     * ]
     * }
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookableIndexResource::collection(
            Bookable::all()
        );
    }


    /**
     * Create
     *
     * Store a newly created Booking in storage
     * @header Authorization: Bearer your_token
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * @response status=200 {
     * "id": 101,
     * "title": "testas 123",
     * "description": "super test",
     * "created_at": "2022-12-16T08:11:56.000000Z",
     * "updated_at": "2022-12-21T13:05:37.000000Z",
     * "price": 200,
     * "user_id": 1
     * }
     *
     * @response status=401 {
     * "message": "Unauthenticated"
     * }
     *
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'user_id' => 'required'
        ]);

        $bookable = Bookable::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price'],
            'user_id' => $data['user_id']
        ]);

        return $bookable;
    }

    /**
     * Show
     *
     * Display the specified Booking.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new BookableShowResource(Bookable::findOrFail($id));
    }


    /**
     * Update
     *
     * Update the Booking resource.
     * @header Authorization: Bearer your_token
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     *
     *
     * @response status=200 {
     * "id": 101,
     * "title": "testas 123",
     * "description": "super test",
     * "created_at": "2022-12-16T08:11:56.000000Z",
     * "updated_at": "2022-12-21T13:05:37.000000Z",
     * "price": 200,
     * "user_id": 1
     * }
     *
     * @response status=401 {
     * "message": "Unauthenticated"
     * }
     */
    public function update(Request $request, $id)
    {
        $bookable = Bookable::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes',
            'description' => 'sometimes',
            'price' => 'sometimes'
        ]);

        $bookable->update([
            'title' => array_key_exists('title', $data) ? $data['title'] : "",
            'description' => array_key_exists('description', $data) ? $data['description'] : "",
            'price' => array_key_exists('price', $data) ? $data['price'] : 0,
        ]);

        return $bookable;
    }

    /**
     * Remove
     *
     * Remove the specified resource from storage.
     * @header Authorization: Bearer your_token
     * @param int $id
     *
     * @response status="200" {
     * "id": 104,
     * "title": "daasd",
     * "description": "dasasd",
     * "created_at": "2022-12-16T08:13:59.000000Z",
     * "updated_at": "2022-12-16T08:13:59.000000Z",
     * "price": 11,
     * "user_id": 1,
     * "user": {
     * "id": 1,
     * "name": "Westley Langosh",
     * "email": "bartoletti.virginie@example.net",
     * "email_verified_at": "2022-12-15T19:44:54.000000Z",
     * "created_at": "2022-12-15T19:44:54.000000Z",
     * "updated_at": "2022-12-15T19:44:54.000000Z"
     * }
     * }
     *
     * @response status=403 scenario="Forbidden" {
     * "status": "403",
     * "message": "Uppss... you cannot be peeking here"
     * }
     */
    public function destroy($id)
    {
        $bookable = Bookable::findOrFail($id);
        if (auth()->user()->hasRole('admin') || auth()->user()->id == $bookable->user->id) {
            $bookable->delete();
            if (Review::where('bookable_id', $bookable->id)->count() > 0) {
                Review::where('bookable_id', $bookable->id)->delete();
            }
            return $bookable;
        }

        return response()->json([
            "status" => "403",
            "message" => "Uppss... you cannot be peeking here"
        ], 403);

    }
}
