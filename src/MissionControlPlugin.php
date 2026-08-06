<?php

namespace PaperLeaf\MissionControl;

use Filament\Contracts\Plugin;
use Filament\Panel;

use PaperLeaf\MissionControl\Pages\ControlDashboard;

class MissionControlPlugin implements Plugin
{
    public const ID = 'mission-control';

    protected string | Closure | null $page_title = null;
    protected string | Closure | null $page_subheading = null;
    protected string | Closure | null $page_icon = null;
    protected string | Closure | null $page_navigation_sort = null;
    protected string | Closure | null $page_navigation_group = null;
    protected string | Closure | null $page_cluster = null;

    public function getId(): string
    {
        return static::ID;
    }

    public function register(Panel $panel): void
    {
        if ($this->page_cluster) {
            ControlDashboard::setClusterClass($this->page_cluster);
        }

        $panel
            ->pages([
                ControlDashboard::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    /**
     * Page Title
     */
    public function pageTitle(string | Closure | null $title): static
    {
        $this->page_title = $title;
        return $this;
    }

    public function getPageTitle(): string | null
    {
        return value($this->page_title);
    }

    /**
     * Page Subheading
     */
    public function pageSubheading(string | Closure | null $subheading): static
    {
        $this->page_subheading = $subheading;
        return $this;
    }

    public function getPageSubheading(): string | null
    {
        return value($this->page_subheading);
    }

    /**
     * Page Icon
     */
    public function pageIcon(string | Closure | null $icon): static
    {
        $this->page_icon = $icon;
        return $this;
    }

    public function getPageIcon(): string | null
    {
        return value($this->page_icon);
    }

    /**
     * Page Navigation Sort
     */
    public function pageNavigationSort(string | Closure | null $navigation_sort): static
    {
        $this->page_navigation_sort = $navigation_sort;
        return $this;
    }

    public function getPageNavigationSort(): string | null
    {
        return value($this->page_navigation_sort);
    }

    /**
     * Page Navigation Group
     */
    public function pageNavigationGroup(string | Closure | null $navigation_group): static
    {
        $this->page_navigation_group = $navigation_group;
        return $this;
    }

    public function getPageNavigationGroup(): string | null
    {
        return value($this->page_navigation_group);
    }

    /**
     * Page Cluster
     */
    public function pageCluster(string $cluster_class): static
    {
        $this->page_cluster = $cluster_class;
        return $this;
    }

    public function getPageCluster(): ?string
    {
        return $this->page_cluster;
    }
}
