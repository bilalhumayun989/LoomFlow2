<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test unauthenticated access redirects to login.
     */
    public function test_unauthenticated_user_redirected_to_login(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    /**
     * Test login page loads successfully.
     */
    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSeeText('LoomFlow');
        $response->assertSeeText('Instant 1-Click Demo Login');
    }

    /**
     * Test authenticated user can access the 6 core operation boxes.
     */
    public function test_authenticated_user_can_access_dashboard_and_modules(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Dashboard Hub
        $response = $this->get('/dashboard?mode=display');
        $response->assertStatus(200);
        $response->assertSeeText('Bags');
        $response->assertSeeText('Sizing');
        $response->assertSeeText('Parts');
        $response->assertSeeText('Fabric Stock');
        $response->assertSeeText('Sales');
        $response->assertSeeText('Production');
        $response->assertSeeText('Loom & Contract Flow');
        $response->assertSeeText('Running loom + quality');
        $response->assertSeeText('Active contract quantities');
        $response->assertSeeText('Unchecked / checked / accepted not recorded');

        // Bags Module
        $response = $this->get('/bags');
        $response->assertStatus(200);
        $response->assertSeeText('Bags (Yarn) Management');

        // Sizing Module
        $response = $this->get('/sizing');
        $response->assertStatus(200);
        $response->assertSeeText('Sizing Dashboard');

        // Parts Module
        $response = $this->get('/parts');
        $response->assertStatus(200);
        $response->assertSeeText('Loom Parts Store & Issuance');

        // Fabric Stock Module
        $response = $this->get('/fabric-stock');
        $response->assertStatus(200);
        $response->assertSeeText('Fabric Stock Dashboard');

        // Sales Module
        $response = $this->get('/sales');
        $response->assertStatus(200);
        $response->assertSeeText('Sales Dashboard');

        // Production Module
        $response = $this->get('/production');
        $response->assertStatus(200);
        $response->assertSeeText('Production Dashboard');

        // Ledgers Module
        $response = $this->get('/ledgers');
        $response->assertStatus(200);
        $response->assertSeeText('Party Ledgers & Statements');
    }

    public function test_dashboard_switches_between_owner_display_and_operator_workspaces(): void
    {
        $this->actingAs(User::factory()->create());

        foreach (['/', '/dashboard?mode=operator'] as $url) {
            $operatorResponse = $this->get($url);

            $operatorResponse->assertOk();
            $operatorResponse->assertSeeText('Daily Transactions');
            $operatorResponse->assertSeeText('Pending Work');
            $operatorResponse->assertSeeText('Recent Records · Quick Print');
            $operatorResponse->assertSeeText('More Tasks');
            $operatorResponse->assertSeeText('Common Lookups');
            $operatorResponse->assertSee('id="dashboard-mode-switch"', false);
            $operatorResponse->assertSee("const dashboardModeSwitch = document.getElementById('dashboard-mode-switch');", false);
            $operatorResponse->assertSee("dashboardModeSwitch.value = dashboardModeSwitch.value === 'display' ? 'operator' : 'display';", false);
            $operatorResponse->assertSee('Alt+7');
            $operatorResponse->assertDontSeeText('All Factory Modules');
        }

        $displayResponse = $this->get('/dashboard?mode=display');

        $displayResponse->assertOk();
        $displayResponse->assertSeeText('LoomFlow Dashboard');
        $displayResponse->assertDontSeeText('All Factory Modules');
        $displayResponse->assertDontSeeText('Daily Transactions');
        $displayResponse->assertSee('id="dashboard-mode-switch"', false);
    }

    public function test_module_display_hides_sidebars_and_supports_ctrl_number_navigation(): void
    {
        $this->actingAs(User::factory()->create());

        $moduleRoutes = [
            'sizing.index',
            'bags.index',
            'parts.index',
            'fabric.index',
            'production.index',
            'sales.index',
            'invoices.index',
            'expenses.index',
        ];

        foreach ($moduleRoutes as $routeName) {
            $response = $this->get(route($routeName, ['mode' => 'display']));

            $response->assertOk();
            $response->assertSee('module-display-mode', false);
            $response->assertSee('module-display-sidebar', false);
            $response->assertSee('id="appSidebar"', false);
        }

        $sizingResponse = $this->get(route('sizing.index', ['mode' => 'display']));

        $sizingResponse->assertSee('body.operator-console.module-display-mode .module-display-sidebar', false);
        $sizingResponse->assertSee("sectionToolbar.setAttribute('aria-label', 'Module section navigation')", false);
        $sizingResponse->assertSee('const moduleSectionNavigation = document.querySelector', false);
        $sizingResponse->assertSee('sectionLink = moduleSectionLinks[Number(event.key) - 1];', false);
        $sizingResponse->assertSee("destination.searchParams.set('mode', 'display');", false);
    }

    public function test_bags_display_subpages_do_not_render_yarn_quality_entry_form(): void
    {
        $this->actingAs(User::factory()->create());

        foreach ([
            ['route' => 'bags.ledger', 'heading' => 'Daily Stock Issuance'],
            ['route' => 'bags.sizing-usage', 'heading' => 'Sizing Bag Consumption'],
        ] as $page) {
            $response = $this->get(route($page['route'], ['mode' => 'display']));

            $response->assertOk();
            $response->assertSeeText($page['heading']);
            $response->assertDontSeeText('Yarn Quality List');
            $response->assertDontSee('id="yarn-quality-form"', false);
            $response->assertDontSee('name="code"', false);
        }

        $operatorResponse = $this->get(route('bags.sizing-usage', ['mode' => 'operator']));

        $operatorResponse->assertOk();
        $operatorResponse->assertSeeText('Yarn Quality List');
        $operatorResponse->assertSee('id="yarn-quality-form"', false);
    }
}
