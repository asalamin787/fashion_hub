<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => '8 Elegant Summer Layering Ideas That Still Feel Light',
                'category' => 'Style Guide',
                'author_name' => 'Ariana Collins',
                'excerpt' => 'Master warm-weather layering with breathable fabrics, softer color balance, and smart accessory pairings that look elevated all day.',
                'content' => implode("\n\n", [
                    'Layering in summer is less about piling on clothes and more about building dimension with lightweight pieces. Start with a clean base such as a cotton tank, ribbed tee, or silk camisole, then add one statement layer that gives structure without heaviness.',
                    'Oversized linen shirts, sleeveless waistcoats, fine-knit cardigans, and relaxed blazers all work well when the silhouette stays airy. The key is contrast. Pair crisp tailoring with fluid bottoms or soft dresses with sharper accessories to make the outfit feel intentional.',
                    'Color plays a major role in making a layered look feel luxurious. Off-white, oat, camel, chocolate, sage, and soft blue create depth without chaos. Instead of reaching for bold prints first, use texture like linen, crochet, poplin, and washed denim to add richness.',
                    'Accessories should support the look rather than compete with it. A slim belt, structured handbag, sculptural sunglasses, and gold-toned jewelry can transform simple layers into a polished outfit that feels styled rather than accidental.',
                    'If you are dressing for long days, keep your outer layer easy to remove and fold. Breathability, movement, and balance matter more than quantity. The best layered outfit feels refined but effortless from morning coffee to evening plans.',
                ]),
                'featured_image' => 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?w=1200&h=700&fit=crop',
                'tags' => ['Summer Style', 'Layering', 'Minimal Fashion', 'Wardrobe'],
                'publish_date' => now()->subDays(2),
                'comments_count' => 12,
                'views_count' => 2480,
                'sort_order' => 1,
            ],
            [
                'title' => 'How To Build A Capsule Wardrobe For Work And Weekend',
                'category' => 'Shopping Tips',
                'author_name' => 'Maya Bennett',
                'excerpt' => 'A practical capsule wardrobe strategy that keeps your closet focused, versatile, and stylish across office days and off-duty plans.',
                'content' => implode("\n\n", [
                    'A strong capsule wardrobe begins with function. Before buying anything new, identify the pieces you reach for most often during a typical week. These are the silhouettes and fabrics that already suit your lifestyle.',
                    'For a balanced wardrobe, focus on a compact edit of trousers, denim, a crisp shirt, elevated basics, one refined knit, a blazer, versatile outerwear, and shoes that cover work, errands, and evenings. The point is flexibility, not restriction.',
                    'Stick to a color palette that mixes easily. Neutrals with one or two accent tones usually create the most outfit combinations. This reduces decision fatigue and makes even simple looks feel composed.',
                    'When shopping, prioritize fit, fabric, and repeat wear over trend urgency. A good capsule wardrobe saves money because each new piece must work with several items you already own.',
                    'Review your wardrobe every season. Remove what no longer serves you and note any gaps. The goal is a closet where most pieces work hard and almost everything can be styled more than one way.',
                ]),
                'featured_image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1200&h=700&fit=crop',
                'tags' => ['Capsule Wardrobe', 'Office Style', 'Weekend Looks', 'Shopping'],
                'publish_date' => now()->subDays(5),
                'comments_count' => 8,
                'views_count' => 1965,
                'sort_order' => 2,
            ],
            [
                'title' => 'Quiet Luxury Accessories That Elevate Everyday Outfits',
                'category' => 'Fashion Trends',
                'author_name' => 'Noah Mercer',
                'excerpt' => 'Small accessory upgrades can shift a basic outfit into a premium look without relying on loud labels or seasonal hype.',
                'content' => implode("\n\n", [
                    'Quiet luxury is defined by restraint. Instead of flashy branding, the focus is on excellent materials, thoughtful shapes, and accessories that complete an outfit with confidence.',
                    'Look for leather belts with clean hardware, structured shoulder bags, slim watches, silk scarves, and timeless loafers. These pieces have longevity because they support many wardrobes rather than a single trend moment.',
                    'Texture is often more important than color. Suede, brushed leather, matte metal, and subtle sheen instantly make an outfit feel richer. Even a plain tee and trousers can look elevated when the finishing details are considered.',
                    'One strong accessory should lead while the others stay quiet. A beautiful bag or refined shoe often creates more impact than stacking several statement pieces together.',
                    'The most effective styling choice is consistency. Repeating the same elevated accessories across different outfits builds a signature look and makes your wardrobe feel more expensive overall.',
                ]),
                'featured_image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=1200&h=700&fit=crop',
                'tags' => ['Quiet Luxury', 'Accessories', 'Trends', 'Minimal Style'],
                'publish_date' => now()->subDays(8),
                'comments_count' => 15,
                'views_count' => 3210,
                'sort_order' => 3,
            ],
            [
                'title' => 'The Best Fabrics To Wear In Humid Weather',
                'category' => 'Style Guide',
                'author_name' => 'Lina Foster',
                'excerpt' => 'Beat heat and humidity with smarter fabric choices that keep outfits breathable, neat, and comfortable from day to night.',
                'content' => implode("\n\n", [
                    'Hot and humid weather exposes every weakness in a wardrobe. Fabrics that trap heat or cling to the body can make even a good outfit feel uncomfortable after a short time outside.',
                    'Linen remains one of the best options because it breathes well and creates natural movement. Cotton poplin and lightweight chambray are also strong choices when you want more structure while still staying cool.',
                    'Rayon blends, soft modal, and airy knits can work beautifully when the fit is relaxed and the garment is not heavily lined. Avoid dense synthetics when possible, especially for long daytime wear.',
                    'Fit matters as much as fabric. A looser silhouette allows air circulation and keeps the garment from sticking to the skin. Choose pieces that skim the body rather than compress it.',
                    'When humidity rises, simplicity wins. Clean lines, breathable fabric, and fewer layers give you the best chance of staying polished without feeling overheated.',
                ]),
                'featured_image' => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?w=1200&h=700&fit=crop',
                'tags' => ['Fabric Guide', 'Summer Style', 'Comfort', 'Wardrobe'],
                'publish_date' => now()->subDays(11),
                'comments_count' => 6,
                'views_count' => 1740,
                'sort_order' => 4,
            ],
            [
                'title' => 'Sustainable Fashion Habits That Actually Make A Difference',
                'category' => 'Sustainability',
                'author_name' => 'Evelyn Hart',
                'excerpt' => 'Thoughtful buying, better garment care, and slower wardrobe decisions can make sustainable fashion realistic and long-lasting.',
                'content' => implode("\n\n", [
                    'Sustainable fashion is not only about buying from the right brands. It is also about reducing unnecessary purchases, extending garment life, and building better habits around how we use what we own.',
                    'Start by buying less and wearing more. Before purchasing, ask whether the item fills a real gap, works with at least three outfits, and still feels relevant beyond a single season.',
                    'Care matters. Washing less often, air drying, storing knits properly, and repairing small issues can significantly extend the life of clothing. Good maintenance is one of the most practical sustainability tools available.',
                    'Consider secondhand, rental, and swapping for special-event pieces or fast-moving trends. These options reduce waste while still allowing creativity and variety in your wardrobe.',
                    'The strongest long-term approach is intentionality. Sustainable style grows when your closet becomes more useful, more loved, and less disposable.',
                ]),
                'featured_image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200&h=700&fit=crop',
                'tags' => ['Sustainability', 'Slow Fashion', 'Wardrobe Care', 'Shopping Tips'],
                'publish_date' => now()->subDays(14),
                'comments_count' => 18,
                'views_count' => 4125,
                'sort_order' => 5,
            ],
            [
                'title' => '5 Outfit Formulas For Instant Smart Casual Style',
                'category' => 'Style Guide',
                'author_name' => 'Julian Reed',
                'excerpt' => 'Reliable smart casual outfit formulas for dinners, meetings, and everyday plans when you want to look polished without overdoing it.',
                'content' => implode("\n\n", [
                    'Smart casual becomes easy when you rely on repeatable formulas instead of starting from scratch every time. A formula gives structure while still allowing personal variation through color and accessories.',
                    'One dependable option is tailored trousers, a fitted tee, and a relaxed blazer. Another is dark denim with a fine-knit top and pointed flats or loafers. A midi skirt with a tucked shirt also works well when balanced with refined accessories.',
                    'For men, smart casual often lands best with clean chinos, a polo or knit tee, and a lightweight overshirt. Sharp sneakers or loafers keep the look grounded without making it feel too formal.',
                    'The success of smart casual comes from balance. Pair one polished piece with one easy piece so the outfit feels natural. Avoid combining too many formal elements unless the setting demands it.',
                    'Build two or three formulas that genuinely suit your routine. Once you know what works, dressing well becomes faster and more consistent.',
                ]),
                'featured_image' => 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=1200&h=700&fit=crop',
                'tags' => ['Smart Casual', 'Outfit Ideas', 'Menswear', 'Womenswear'],
                'publish_date' => now()->subDays(18),
                'comments_count' => 9,
                'views_count' => 2875,
                'sort_order' => 6,
            ],
            [
                'title' => 'Designer Spotlight: Modern Labels Redefining Everyday Luxury',
                'category' => 'Designer Spotlight',
                'author_name' => 'Sophia Lane',
                'excerpt' => 'A look at contemporary labels using precise tailoring, premium fabrication, and wearable design to define modern luxury.',
                'content' => implode("\n\n", [
                    'The most exciting modern labels are not chasing shock value. They are refining the fundamentals of good dressing through shape, quality, and subtle innovation.',
                    'Many standout designers focus on wearable silhouettes that feel easy in daily life but elevated in finish. Think softened tailoring, rich neutrals, exceptional knitwear, and bags with sculptural restraint.',
                    'What sets these brands apart is consistency. Their collections build on a clear visual language, making pieces easier to style season after season instead of feeling outdated after a few months.',
                    'When evaluating a designer, look beyond the runway highlight. Consider how the fabrics move, how the garments sit on the body, and whether the construction supports frequent wear.',
                    'True everyday luxury is measured by use. The best designer pieces become regular favorites because they deliver both beauty and practicality.',
                ]),
                'featured_image' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=1200&h=700&fit=crop',
                'tags' => ['Designer Spotlight', 'Luxury', 'Fashion Trends', 'Editorial'],
                'publish_date' => now()->subDays(22),
                'comments_count' => 11,
                'views_count' => 3540,
                'sort_order' => 7,
            ],
            [
                'title' => 'What To Buy On Sale Without Regretting It Later',
                'category' => 'Shopping Tips',
                'author_name' => 'Harper Cole',
                'excerpt' => 'A disciplined sale-shopping approach that helps you spot real wardrobe value instead of collecting expensive mistakes.',
                'content' => implode("\n\n", [
                    'Sale season can either sharpen your wardrobe or clutter it. The difference usually comes down to whether you shop from a list or from a temporary sense of urgency.',
                    'Start with gaps. If you need a better coat, versatile shoes, or upgraded basics, sales are a smart time to invest. If the item solves no real need, the discount rarely makes it a good purchase.',
                    'Check fabrication and fit before the price tag. Beautiful materials and great construction hold value. Poor fit and weak fabric become regrets, no matter how much you save.',
                    'Avoid buying trend pieces only because they are marked down. If you would not consider them at full price, they probably do not deserve space in your wardrobe.',
                    'The best sale purchase is something you will wear repeatedly within the next month. Immediate relevance is one of the clearest signs that the buy is worth it.',
                ]),
                'featured_image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=1200&h=700&fit=crop',
                'tags' => ['Sale Shopping', 'Wardrobe Planning', 'Shopping Tips', 'Style'],
                'publish_date' => now()->subDays(27),
                'comments_count' => 7,
                'views_count' => 1680,
                'sort_order' => 8,
            ],
        ];

        foreach ($posts as $index => $post) {
            $slug = Str::slug($post['title']);

            BlogPost::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $post['title'],
                    'slug' => $slug,
                    'category' => $post['category'],
                    'author_name' => $post['author_name'],
                    'excerpt' => $post['excerpt'],
                    'content' => $post['content'],
                    'featured_image' => $post['featured_image'],
                    'tags' => $post['tags'],
                    'publish_date' => $post['publish_date'],
                    'comments_count' => $post['comments_count'],
                    'views_count' => $post['views_count'],
                    'is_published' => true,
                    'sort_order' => $post['sort_order'] ?? ($index + 1),
                ],
            );
        }
    }
}
