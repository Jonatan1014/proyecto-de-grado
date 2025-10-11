<?php
// src/app/Controllers/AdminController.php

require_once __DIR__ . '/../Services/AuthService.php';


class AdminController {

    public function index() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/dashboard.php';
    }
    // public function appsCalendar() {
    //     AuthService::requireLogin();

    //     if (!AuthService::isAdminOrRoot()) {
    //         header("Location: login");
    //         exit;
    //     }

    //     include __DIR__ . '/../Views/admin/apps-calendar.php';
    // }

    public function appsTasks() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/apps-tasks.php';
    }

    public function pagesProfile() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-profile.php';
    }

 
    

}