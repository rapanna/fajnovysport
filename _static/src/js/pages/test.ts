class Test {
	constructor() {
		console.log("Test");
		this.init();
	}

	private init(): void {
		console.log("init");
	}
}
export default new Test();
