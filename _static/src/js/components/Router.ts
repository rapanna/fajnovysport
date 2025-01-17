/**
 * component for routing JS scripts with element body attribute
 * - data-controller
 * - data-action
 */

export class Router {
	// eslint-disable-next-line @typescript-eslint/no-explicit-any
	private controller: string | any;
	// eslint-disable-next-line @typescript-eslint/no-explicit-any
	private controllers: Record<string, any>;
	private action: string | null;

	constructor(controller = null, action = null) {
		this.controllers = {};
		this.controller = controller;
		this.action = action;
	}

	public register(controllers = {}): void {
		this.controllers = controllers;
	}

	private discoverRoute(): void {
		if (this.controller === null) {
			this.controller = document.body.getAttribute("data-controller");
		}

		if (this.action === null) {
			this.action = document.body.getAttribute("data-action");
		}
	}

	public run(): void {
		this.discoverRoute();
		const controller = new this.controllers[
			this.controller in this.controllers ? this.controller : "Base"
		]();
		this.runController(controller);
		return controller;
	}

	// eslint-disable-next-line @typescript-eslint/no-explicit-any
	private runController(controller: any): void {
		if (controller.startup) {
			controller.startup();
		}
		if (this.action) {
			const name =
				this.action.charAt(0).toUpperCase() + this.action.slice(1);
			const actionName = "action" + name;
			const renderName = "render" + name;

			if (actionName in controller) {
				controller[actionName]();
			}

			if ("beforeRender" in controller) {
				controller.beforeRender();
			}

			if (renderName in controller) {
				controller[renderName]();
			}

			window.addEventListener("load", () => {
				if ("afterRender" in controller) {
					controller.afterRender();
				}
			});
		}
	}
}
