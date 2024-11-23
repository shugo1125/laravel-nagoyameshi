<?php

namespace Tests\Feature;

use App\Models\User; // Users テーブル用のモデル
use App\Models\Admin; // Admins テーブル用のモデル
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;



    /**
     * 未ログインのユーザーは管理者側の会員一覧ページにアクセスできない
     */
    public function test_non_logged_in_user_cannot_access_member_list_page(): void
    {
        $response = $this->get('/admin/users');
        $response->assertRedirect('/admin/login'); // 修正
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の会員一覧ページにアクセスできない
     */
    public function test_logged_in_user_cannot_access_member_list_page(): void
    {
        // 一般ユーザーを作成しログイン
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/admin/users');

        $response->assertRedirect('/admin/login'); // アクセス禁止

    }
    /**
     * ログイン済みの管理者は管理者側の会員一覧ページにアクセスできる
     */
    public function test_logged_in_admin_can_access_member_list_page(): void
    {
        // 管理者ユーザーを作成しログイン
        $admin = Admin::factory()->create(); // Admin モデルを使用

        $this->actingAs($admin, 'admin');


        $response = $this->get('/admin/users');
        $response->assertStatus(200); // 正常にアクセスできる
    }

    /**
     * 未ログインのユーザーは管理者側の会員詳細ページにアクセスできない
     */
    public function test_non_logged_in_user_cannot_access_member_detail_page(): void
    {
        $response = $this->get('/admin/users/1');
        $response->assertRedirect('/admin/login'); // 修正
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の会員詳細ページにアクセスできない
     */
    public function test_logged_in_user_cannot_access_member_detail_page(): void
    {
        // 一般ユーザーを作成しログイン
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/admin/users/1');

        $response->assertRedirect('/admin/login'); // アクセス禁止
    }

    /**
     * ログイン済みの管理者は管理者側の会員詳細ページにアクセスできる
     */
    public function test_logged_in_admin_can_access_member_detail_page(): void
    {
        // 管理者ユーザーを作成しログイン
        $admin = Admin::factory()->create(); // Admin モデルを使用

        $this->actingAs($admin, 'admin');

        // ダミーユーザーを作成
        $user = User::factory()->create();

        $response = $this->get('/admin/users/' . $user->id);
        $response->assertStatus(200); // 正常にアクセスできる
    }
}
