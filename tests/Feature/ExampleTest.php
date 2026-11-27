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
            $operatorResponse->assertSee('Alt+7');
            $operatorResponse->assertDontSeeText('All Factory Modules');
        }

        $displayResponse = $this->get('/dashboard?mode=display');

        $displayResponse->assertOk();
        $displayResponse->assertSeeText('LoomFlow Dashboard');
        $displayResponse->assertSeeText('All Factory Modules');
        $displayResponse->assertDontSeeText('Daily Transactions');
        $displayResponse->assertSee('id="dashboard-mode-switch"', false);
    }
}
