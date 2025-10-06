<script>
    $(function() {
        'use strict';
        // Ajax survey generate
        const chatContainer = $("#chatContainer");
        const chatMessages = $("#chatMessages");
        const defaultChatMessage = $(".defaultChatMessage");
        const defaultPromptMessage = $(".defaultPrompt");
        const generateBtn = $("#generateBtn");
        const promptInput = $("#prompts");

        // Append Message Function
        function appendMessage(content, type = "ai") {
            const msgClass = type === "user" ?
                "bg-primary text-white align-self-end" :
                "bg-white border align-self-start";
            const msg = `<div class="p-3 rounded ${msgClass}" style="max-width:80%">${content}</div>`;
            chatMessages.append(msg);
            if (!defaultPromptMessage.hasClass('d-none')) {
                defaultPromptMessage.addClass('d-none');
            }
            defaultText();
            chatContainer.scrollTop(chatContainer[0].scrollHeight);
        }

        // Generate Survey AJAX Function
        function generateSurvey(prompt) {
            if (!prompt.trim()) return;
            appendMessage(prompt, "user");
            promptInput.val("");
            appendMessage("<i class='fa fa-spinner fa-spin'></i> AI is generating survey...", "ai");
            $.ajax({
                url: "{{ route('admin.survey.generate') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    prompt: prompt,
                },
                success: function(res) {
                    chatMessages.find(".fa-spinner").closest("div").remove();

                    // Render the survey form
                    if (typeof renderSurveyForm === "function") {
                        renderSurveyForm(res.data);
                    } else {
                        console.error("renderSurveyForm is not defined!");
                    }

                    try {
                        const jsonStr = JSON.stringify(res.data || res, null, 4);
                        appendMessage(`<pre class="m-0"><code>${jsonStr}</code></pre>`, "ai");
                    } catch (e) {
                        appendMessage("Invalid JSON output received.", "ai");
                    }
                },
                error: function() {
                    chatMessages.find(".fa-spinner").closest("div").remove();
                    appendMessage("Something went wrong! Please try again.", "ai");
                }
            });
        }

        //  Generate Button Click
        generateBtn.on("click", function() {
            const prompt = promptInput.val();
            generateSurvey(prompt);
        });

        //  Main Render Survey
        function renderSurveyForm(surveyData) {
            const container = $("#surveyFormContainer");
            $("#saveSurveyBtn").removeClass("d-none");
            const survey = surveyData;
            if (!survey || !survey.questions) {
                container.html("<div class='alert alert-danger'>Invalid survey data.</div>");
                return;
            }

            isNeededRenderSurveyTitle(container, survey.title);
            survey.questions.forEach((q) => {
                container.append(renderQuestion(q));
            });
        }

        // Render Survey Title
        function renderSurveyTitle(title) {
            return `
                    <div class="mb-3">
                        <label class="form-label fw-bold">Survey Title</label>
                        <input type="text" class="form-control" name="survey_title" value="${title}">
                    </div>
                `;
        }

        //  Render Single Question
        function renderQuestion(q) {
            const totalQuestions = $(".question-item").length;
            const questionNumber = totalQuestions + 1;

            const questionDiv = $(`
                    <div class="card mb-3 question-item" data-id="${q.id}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="drag-handle me-2" style="cursor: move;">
                                        <i class="fa fa-bars"></i>
                                    </span>
                                    <strong class="question-number">Question ${questionNumber}</strong>
                                </div>
                                <button type="button" class="btn btn-sm btn-danger delete-question">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Question Text</label>
                                <input type="text" class="form-control question-text" value="${q.question}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Type</label>
                                <select class="form-select question-type">
                                    <option value="mcq_single" ${q.type === 'mcq_single' ? 'selected' : ''}>Single Choice</option>
                                    <option value="mcq_multiple" ${q.type === 'mcq_multiple' ? 'selected' : ''}>Multiple Choice</option>
                                    <option value="written_input" ${q.type === 'written_input' ? 'selected' : ''}>Short Answer</option>
                                    <option value="written_textarea" ${q.type === 'written_textarea' ? 'selected' : ''}>Long Answer</option>
                                </select>
                            </div>
                            <div class="options-area"></div>
                        </div>
                    </div>
                `);

            if (q.options && q.options.length) {
                renderOptionsBlock(questionDiv.find(".options-area"), q.options);
            }

            return questionDiv;
        }

        //  Render Options Block
        function renderOptionsBlock(container, options = ["Option 1"]) {
            const optionsDiv = $('<div class="mb-2"><label class="form-label">Options</label></div>');
            const optionsList = $('<div class="options-list"></div>');

            options.forEach((opt, ind) => {
                optionsList.append(`
                        <div class="d-flex mb-2 option-item">
                            <input type="text" class="form-control option-input" value="${opt}">
                            ${ind > 0 ? `
                                <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-option">
                                    <i class="fa fa-times"></i>
                                </button>` : ''}
                        </div>
                    `);
            });

            optionsDiv.append(optionsList);
            optionsDiv.append(`
                    <button type="button" class="btn btn-sm btn-outline-primary add-option">
                        <i class="fa fa-plus"></i> Add Option
                    </button>
                `);

            container.append(optionsDiv);
        }

        //  Add Option Event
        $(document).on("click", ".add-option", function() {
            'use strict';
            const list = $(this).siblings(".options-list");
            list.append(renderOptionItem());
        });

        //  Remove Option Event
        $(document).on("click", ".remove-option", function() {
            'use strict';
            const optionsList = $(this).closest(".options-list");
            if (optionsList.find(".option-item").length <= 1) {
                notify('error', "At least one option is required!");
                return;
            }
            $(this).closest(".option-item").remove();
        });

        //  Delete Question Event
        $(document).on("click", ".delete-question", function() {
            'use strict';
            $(this).closest(".question-item").remove();
            // Re-index remaining questions
            reindexQuestions();
            toggleSaveButton();
        });

        //  Question Type Change Event
        $(document).on("change", ".question-type", function() {
            'use strict';
            const selectedType = $(this).val();
            const optionsArea = $(this).closest(".question-item").find(".options-area");

            if (selectedType === "mcq_single" || selectedType === "mcq_multiple") {
                if (!optionsArea.children().length) renderOptionsBlock(optionsArea);
            } else {
                optionsArea.empty();
            }
        });

        //  Helper: Render Single Option Item
        function renderOptionItem() {
            return `
                    <div class="d-flex mb-2 option-item">
                        <input type="text" class="form-control option-input" placeholder="New Option">
                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-option">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `;
        }

        //  Show/hide Save button depending on questions
        function toggleSaveButton() {
            const saveBtn = $("#saveSurveyBtn");
            const container = $("#surveyFormContainer");

            if ($("#surveyFormContainer .question-item").length === 0) {
                saveBtn.addClass("d-none"); // hide
                container.empty();
                defaultChatMessage.removeClass('d-none');
            } else {
                saveBtn.removeClass("d-none"); // show
            }
        }

        // Helper Function: Re-index Question Titles
        function reindexQuestions() {
            $(".question-item").each(function(index) {
                $(this)
                    .find("strong")
                    .text(`Question ${index + 1}`);
            });
        }

        //  Helper: Collect Survey Data
        function collectSurveyData() {
            const survey = {
                title: $("input[name='survey_title']").val(),
                questions: []
            };

            $(".question-item").each(function(index) {
                const q = {
                    id: index + 1,
                    type: $(this).find(".question-type").val(),
                    question: $(this).find(".question-text").val()
                };

                const opts = [];
                $(this).find(".option-input").each(function() {
                    const val = $(this).val().trim();
                    if (val) opts.push(val);
                });
                if (opts.length) q.options = opts;
                survey.questions.push(q);
            });

            return survey;
        }

        //  Add New Question Event
        $("#addQuestionBtn").on("click", function() {
            const container = $("#surveyFormContainer");
            const newQuestion = {
                id: Date.now(),
                type: "mcq_single",
                question: "New Question",
                options: ["Option 1", "Option 2"]
            };
            $("#saveSurveyBtn").removeClass("d-none");

            defaultText();
            isNeededRenderSurveyTitle(container);
            // Render new question and append
            container.append(renderQuestion(newQuestion, container.find(".question-item").length));
            toggleSaveButton();
        });

        function defaultText() {
            if (!defaultChatMessage.hasClass('d-none')) {
                defaultChatMessage.addClass('d-none');
            }
        }

        function isNeededRenderSurveyTitle(container, title) {
            if (!container.find("input[name='survey_title']").length) {
                container.append(renderSurveyTitle(title ?? 'New Survey Title'));
            }
        }

        // Save Survey Event json
        $("#saveSurveyBtn").on("click", function() {
            const surveyData = collectSurveyData();
            $.ajax({
                url: "{{ route('admin.survey.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    survey: surveyData,
                },
                success: function(response) {
                    console.log("Survey saved successfully:", response);
                    if (response.status === "success") {
                        // window.location.href = "{{ route('admin.survey.index') }}";
                        notify('success', response.message);
                        return;
                    } else {
                        notify('error', response.message);
                    }
                },
                error: function(xhr) {
                    notify('error', "Error saving survey:", xhr.responseText);
                }
            });
        });


        $("#surveyFormContainer").sortable({
            handle: ".drag-handle",
            tolerance: "pointer",
            items: ".question-item",
            axis: "y",
            placeholder: "sortable-placeholder",
            start: function(event, ui) {
                ui.item.addClass("dragging");
                ui.placeholder.height(ui.item.height());
            },

            stop: function(event, ui) {
                ui.item.removeClass("dragging");
                reserializeQuestionNumbers();
            },
            update: function() {
                reserializeQuestionNumbers();
            }
        });

        function reserializeQuestionNumbers() {
            $("#surveyFormContainer .question-item").each(function(index) {
                $(this).find(".question-number").text(`Question ${index + 1}`);
            });
        }

    });
</script>
