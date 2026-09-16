# EXACT LARAVEL 12 CODING STANDARDS

All code must strictly follow the coding standards below. These rules are mandatory unless the existing project has an established convention that must be preserved.

---

## 1. PHP VERSION & STRICT TYPES

Target:

* Laravel 12
* PHP 8.3+

Every new PHP file should use strict types unless the existing project convention explicitly does not use it.

```php
<?php

declare(strict_types=1);

namespace App\Services;

```

Always use:

* Strict typing
* Type declarations for parameters
* Return types
* Nullable types where appropriate
* Union types only when genuinely required

### Correct

```php
public function findById(int $id): ?User
{
    return User::find($id);
}

```

### Avoid

```php
public function findById($id)
{
    return User::find($id);
}

```

---

# 2. PSR-12 FORMATTING

Strictly follow PSR-12 formatting standards.

Rules:

* 4 spaces for indentation.
* Never use tabs.
* One class per file.
* Opening braces must follow PSR-12.
* Maximum readability is more important than minimizing lines.
* Remove unnecessary blank lines.
* Do not use trailing whitespace.
* Use one blank line between logical sections.

Example:

```php
final class CreateProjectAction
{
    public function __construct(
        private readonly ProjectService $projectService,
    ) {
    }

    public function handle(array $data): Project
    {
        return $this->projectService->create($data);
    }
}

```

---

# 3. IMPORTS & NAMESPACES

Always use imports instead of fully qualified class names inside methods.

### Correct

```php
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function show(User $user): JsonResponse
    {
        // ...
    }
}

```

### Avoid

```php
public function show(
    \App\Models\User $user
): \Illuminate\Http\JsonResponse {
}

```

Organize imports consistently:

```php
use App\Enums\ProjectStatus;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

```

Remove unused imports.

---

# 4. CLASS DESIGN

Use descriptive class names.

Examples:

```text
User
Project
Order
CreateProjectAction
UpdateProjectAction
ProjectService
StoreProjectRequest
UpdateProjectRequest
ProjectResource
ProjectPolicy

```

Avoid vague names:

```text
Helper
Manager
Handler
Utility
Common
Functions
Data
Process

```

unless the responsibility is extremely clear.

Prefer `final` for classes that are not intended to be extended.

```php
final class CreateProjectAction
{
}

```

Do not use `final` when Laravel or another framework mechanism requires extension.

---

# 5. PROPERTY DECLARATION

Use constructor property promotion.

Prefer `private readonly` for dependencies that should not change.

```php
final class ProjectService
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
    ) {
    }
}

```

Avoid:

```php
private ProjectRepository $projectRepository;

public function __construct(ProjectRepository $projectRepository)
{
    $this->projectRepository = $projectRepository;
}

```

unless mutation is actually required.

---

# 6. METHOD STANDARDS

Every public method must have:

* Clear responsibility
* Proper parameter types
* Proper return type
* Descriptive name

### Good

```php
public function createProject(
    User $user,
    array $data,
): Project

```

### Avoid

```php
public function process($data)

```

Keep methods focused.

If a method becomes difficult to understand, extract meaningful private methods.

### Example

```php
public function create(array $data): Project
{
    return DB::transaction(
        fn (): Project => $this->storeProject($data)
    );
}

```

---

# 7. CONTROLLER STANDARDS

Controllers must remain thin.

A controller should only:

1. Receive the request.
2. Authorize if necessary.
3. Pass validated data to an Action or Service.
4. Return a response.

Example:

```php
final class ProjectController extends Controller
{
    public function store(
        StoreProjectRequest $request,
        CreateProjectAction $action,
    ): JsonResponse {
        $project = $action->handle(
            user: $request->user(),
            data: $request->validated(),
        );

        return response()->json(
            new ProjectResource($project),
            201,
        );
    }
}

```

Do not place:

* Complex queries
* Business workflows
* Multiple database operations
* Complex calculations
* Large conditional logic

inside Controllers.

---

# 8. FORM REQUEST STANDARDS

Use Form Requests for validation.

File naming:

```text
StoreProjectRequest
UpdateProjectRequest
DeleteProjectRequest

```

Example:

```php
final class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}

```

Prefer array validation rules:

```php
'name' => [
    'required',
    'string',
    'max:255',
],

```

instead of:

```php
'name' => 'required|string|max:255',

```

---

# 9. MODEL STANDARDS

Models should contain:

* Relationships
* Casts
* Query scopes
* Accessors / Mutators when necessary
* Small domain-specific methods

Example:

```php
final class Project extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'published_at' => 'datetime',
            'status' => ProjectStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}

```

Always define relationship return types.

Avoid putting large workflows inside Models.

---

# 10. ELOQUENT QUERY STANDARDS

Avoid N+1 queries.

### Bad

```php
$projects = Project::all();

foreach ($projects as $project) {
    echo $project->user->name;
}

```

### Good

```php
$projects = Project::query()
    ->with('user')
    ->get();

```

Always use:

```php
Model::query()

```

for complex queries.

Example:

```php
$projects = Project::query()
    ->with([
        'user',
        'tasks',
    ])
    ->where('status', ProjectStatus::Active)
    ->latest()
    ->paginate();

```

---

# 11. DATABASE STANDARDS

Migration names must clearly describe the operation.

Examples:

```text
create_projects_table
add_status_to_projects_table
create_project_user_table

```

Use proper foreign keys:

```php
$table->foreignId('user_id')
    ->constrained()
    ->cascadeOnDelete();

```

Only use cascade deletion when it is logically correct.

Always consider indexes:

```php
$table->index('status');
$table->index(['user_id', 'status']);

```

Use unique constraints when required:

```php
$table->string('slug')->unique();

```

---

# 12. DATABASE TRANSACTIONS

Use database transactions when multiple database operations must succeed together.

```php
return DB::transaction(function () use ($data): Project {
    $project = Project::create($data);

    $project->tasks()->createMany(
        $this->prepareTasks($data['tasks'])
    );

    return $project;
});

```

Do not use transactions for simple single queries unnecessarily.

---

# 13. ACTION & SERVICE STANDARDS

Use an Action for a specific use case.

Example:

```text
CreateProjectAction
UpdateProjectAction
DeleteProjectAction

```

Each Action should have one primary responsibility.

```php
final class CreateProjectAction
{
    public function handle(
        User $user,
        array $data,
    ): Project {
        return DB::transaction(function () use (
            $user,
            $data,
        ): Project {
            return $user->projects()->create($data);
        });
    }
}

```

Use Services for reusable business logic shared across multiple actions.

Do not create a Service for every model automatically.

---

# 14. REPOSITORY RULES

Do not automatically use the Repository Pattern.

Use repositories only when they provide real value, such as:

* Multiple data sources
* Complex query abstraction
* Swappable persistence layers
* Large domain complexity

For normal Laravel Eloquent operations, use Eloquent directly.

Avoid unnecessary structures like:

```text
ProjectRepository
ProjectRepositoryInterface
EloquentProjectRepository

```

for simple CRUD.

---

# 15. API RESPONSE STANDARDS

Use API Resources for API output.

```php
final class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}

```

Use proper HTTP status codes:

```text
200 → Success
201 → Created
204 → No Content
400 → Bad Request
401 → Unauthenticated
403 → Forbidden
404 → Not Found
422 → Validation Error
429 → Too Many Requests
500 → Server Error

```

Do not return inconsistent API structures.

---

# 16. NAMING CONVENTIONS

Use clear English names.

### Classes

```text
CreateProjectAction
ProjectController
ProjectPolicy
ProjectResource
StoreProjectRequest

```

### Methods

Use camelCase:

```php
createProject()
updateProject()
deleteProject()
calculateTotal()

```

### Variables

Use descriptive camelCase:

```php
$projectOwner
$activeProjects
$totalAmount

```

Avoid:

```php
$data
$item
$result
$temp
$value

```

when a more meaningful name is possible.

### Database

Use snake_case:

```text
user_id
created_at
updated_at
published_at

```

### Tables

Use plural snake_case:

```text
users
projects
project_tasks
order_items

```

---

# 17. ENUM STANDARDS

Use Enums for fixed states.

```php
enum ProjectStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Completed = 'completed';
    case Archived = 'archived';
}

```

Do not use magic strings throughout the application.

### Avoid

```php
if ($project->status === 'active') {
}

```

Prefer:

```php
if ($project->status === ProjectStatus::Active) {
}

```

---

# 18. EXCEPTION HANDLING

Never silently ignore exceptions.

Bad:

```php
try {
    // ...
} catch (Throwable $exception) {
}

```

Log meaningful context when necessary:

```php
Log::error(
    'Project creation failed.',
    [
        'user_id' => $user->id,
        'exception' => $exception,
    ],
);

```

Do not expose internal exception details to users in production.

---

# 19. COMMENTS & PHPDOC

Do not write unnecessary comments.

Bad:

```php
// Get the user
$user = User::find($id);

```

The code should explain itself.

Use comments only when explaining:

* Complex business decisions
* Non-obvious logic
* Important technical constraints

Do not add PHPDoc for obvious typed code.

Use PHPDoc when necessary for:

* Complex array shapes
* Generics
* Collection types
* Framework limitations

Example:

```php
/**
 * @return Collection<int, Project>
 */
public function active(): Collection
{
    // ...
}

```

---

# 20. TESTING STANDARDS

Every important feature should be testable.

Prefer feature tests for:

* HTTP endpoints
* Authentication
* Authorization
* Database workflows

Use unit tests for isolated business logic.

Follow Arrange → Act → Assert.

Example:

```php
it('creates a project for an authenticated user', function (): void {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->postJson('/api/projects', [
            'name' => 'My Project',
        ]);

    $response
        ->assertCreated()
        ->assertJsonPath('data.name', 'My Project');

    $this->assertDatabaseHas('projects', [
        'name' => 'My Project',
        'user_id' => $user->id,
    ]);
});

```

---

# 21. LARAVEL 12 DEFAULT-FIRST RULE

Before adding:

* Custom helpers
* Custom abstractions
* Third-party packages
* Complex design patterns

First check whether Laravel already provides a clean native solution.

Prefer Laravel conventions whenever possible.

Do not reinvent:

* Authentication
* Authorization
* Validation
* Events
* Notifications
* Queues
* Caching
* Rate limiting
* Filesystem handling

---

# 22. CODE QUALITY CHECKLIST

Before providing final code, verify:

* Code follows Laravel 12 conventions.
* Code follows PSR-12.
* Strict types are used where compatible with the project.
* Parameters have proper types.
* Methods have return types.
* Imports are clean and unused imports are removed.
* No unnecessary abstraction was introduced.
* Controllers remain thin.
* Validation uses Form Requests where appropriate.
* Authorization is handled correctly.
* N+1 queries are avoided.
* Database indexes were considered.
* Transactions are used only when necessary.
* Error handling is appropriate.
* Sensitive information is not exposed.
* Existing functionality is preserved.
* Code is readable and maintainable.
* The solution is not over-engineered.

---

# FINAL CODING PRINCIPLE

Always prioritize this order:

1. Correctness
2. Security
3. Maintainability
4. Laravel conventions
5. Readability
6. Performance
7. Scalability
8. Abstraction only when necessary

**Do not over-engineer.**

The preferred solution is always:

> The simplest production-ready solution that follows Laravel 12 conventions and fits naturally into the existing project architecture.

all time code inline if need separate html and scss
