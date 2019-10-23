<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/Pacjonek
 * @since      1.0.0
 *
 * @package    Todo
 * @subpackage Todo/public/partials
 */
?>

<div class="todo">
    <div class="todo-task todo-task--new">
        <div class="todo-task__done-outer">
            <input class="todo-task__done" type="checkbox">
        </div>
        <input class="todo-task__job" placeholder="Enter new task here...">
    </div>
    <ul class="todo-task__list">
        <div class="todo-task__loading">Loading...</div>
    </ul>
</div>