<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $user;
    protected $user_id;
    protected $user_role;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('User_model');
        
        // Get current user from session
        $this->user = $this->session->userdata('user');
        if ($this->user) {
            $this->user_id = $this->user['id'];
            $this->user_role = $this->user['role'];
        }
    }

    /**
     * Proteksi halaman yang membutuhkan login
     * Redirect ke login jika belum login
     */
    protected function require_login() {
        if (!$this->session->userdata('user')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu');
            redirect('auth/login');
        }
    }

    /**
     * Proteksi untuk single role
     * @param string $role Role yang diizinkan
     */
    protected function require_role($role) {
        $user = $this->session->userdata('user');
        if (!$user || $user['role'] !== $role) {
            show_error('Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.', 403);
        }
    }

    /**
     * Proteksi untuk multiple roles
     * @param array $roles Array dari roles yang diizinkan
     */
    protected function require_any_role($roles = []) {
        $user = $this->session->userdata('user');
        if (!$user || !in_array($user['role'], $roles)) {
            show_error('Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.', 403);
        }
    }

    /**
     * Shortcut untuk owner only
     */
    protected function require_owner() {
        $this->require_role('owner');
    }

    /**
     * Shortcut untuk kasir only (formerly admin)
     */
    protected function require_kasir() {
        $this->require_role('kasir');
    }

    /**
     * Shortcut untuk kasir dan owner (management roles)
     */
    protected function require_management() {
        $this->require_any_role(['kasir', 'owner']);
    }

    /**
     * Get current logged-in user data
     */
    protected function get_user() {
        return $this->user;
    }

    /**
     * Get user ID
     */
    protected function get_user_id() {
        return $this->user_id;
    }

    /**
     * Get user role
     */
    protected function get_user_role() {
        return $this->user_role;
    }

    /**
     * Check if user is kasir
     */
    protected function is_kasir() {
        return $this->user_role === 'kasir';
    }

    /**
     * Check if user is owner
     */
    protected function is_owner() {
        return $this->user_role === 'owner';
    }

    /**
     * Check if user is logged in
     */
    protected function is_logged_in() {
        return $this->user !== null;
    }
}
