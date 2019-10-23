(($)=>{
	const documentReady = $.Deferred();
	let ajaxResponse = [];
	const ajaxRequest = $.getJSON(`${ajaxOptions.adminAjaxUrl}?action=get_todo_tasks`,(e)=>{
		ajaxResponse = e;
	});
	ajaxRequest.fail((e)=>{
		$('.todo-task__loading').css("display","none");
		alert('Error. We couldn\'t download your todo tasks');
		console.log(e)
	});
	
	function appendTask(task, done){
		$('.todo-task__list').append(`
			<li class="todo-task">
				<div class="todo-task__done-outer">
					<input class="todo-task__done" type="checkbox" ${done === true || done === 'true' ? 'checked' : ''}>
				</div>
				<input class="todo-task__job" placeholder="Enter new task here" value="${task}">
			</li>
		`);
	}
	function updateTasks(){
		let tasks = [];
		Array.from($('.todo-task:not(.todo-task--new)')).forEach((el)=>{
			if($(el).find('.todo-task__job').val() == '') {
				$(el).css('display','none');
				return;
			}
			tasks.push(
			{
				task:$(el).find('.todo-task__job').val(),
				done:$(el).find('.todo-task__done').prop('checked')
			}
			);
		});
		$.post(`${ajaxOptions.adminAjaxUrl}?action=update_todo_tasks`,{
			data:tasks
		}).fail((e)=>{
			alert('Error. We couldn\'t update your tasks with our database');
			console.log(e)
		});
	}
	function changeTaskInput(target, addNew = false){
		const parentTarget = target.parentNode;
		if(addNew && $(parentTarget).hasClass('todo-task--new')){
			prepareNewTask(parentTarget);
		}
		updateTasks();
	}
	function prepareNewTask(target){
		appendTask($(target).find('.todo-task__job').val(), $(target).find('.todo-task__done').prop('checked'));
		$(target).find('.todo-task__job').val('');
		$(target).find('.todo-task__done').prop('checked', false);
	}
	$.when(documentReady, ajaxRequest).then(()=>{
		$('.todo-task__loading').css("display","none");
		$('.todo-task__list').addClass("loaded");
		if(!ajaxResponse || ajaxResponse.length === 0) return;
		ajaxResponse.forEach((el)=>{
			appendTask(el.task, el.done)
		})
	});

	$(document).ready(()=>{
		documentReady.resolve()
	});
	$(document).on({
		change: (e)=>{
			changeTaskInput(e.currentTarget)
		}, 
		keypress: (e)=>{
			if(e.keyCode == 13){
				changeTaskInput(e.currentTarget, true)
			}
		}
	},'.todo-task__job, .todo-task__done');
})(jQuery);