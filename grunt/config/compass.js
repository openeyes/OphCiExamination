var path = require('path');

module.exports = function(grunt) {

	// Get the path to the core 'sass' directory.
	// We add this import path to the compass compilation so that we can import the
	// core mixins, functions and variables.
	var importPath = (function getimportPath() {

		var paths = [
			'..',
			'..',
			'..',
			'sass',
			'new'
		];

		if (!grunt.file.exists.apply(grunt.file, paths)) {
			grunt.fail.warn('Unable to compile Sass as this module does not exist within the OpenEyes core application.');
			return null;
		}

		return path.join.apply(path, paths);
	}());

	return {
		dist: {
			options: {
				sassDir: 'assets/sass',
				cssDir: 'assets/css',
				imagesDir: 'assets/img/new',
				generatedImagesDir: 'assets/img/sprites',
				importPath: importPath,
				outputStyle: 'expanded',
				relativeAssets: true,
				httpPath: '',
				noLineComments: false
			}
		}
	};
};