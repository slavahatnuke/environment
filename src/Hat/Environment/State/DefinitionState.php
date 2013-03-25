<?php
namespace Hat\Environment\State;

class DefinitionState extends State
{
    const FIXED = 'fixed';

    const NOT_FIXED = 'not_fixed';

    const SKIP = 'skip';

    const ON_PASS_FAIL = 'on_pass_fail';

    const ON_PASS_OK = 'on_pass_ok';

    const ON_FAIL_FAIL = 'on_fail_fail';

    const ON_FAIL_OK = 'on_fail_ok';

    public function isFail()
    {
        return $this->isState(array(
            self::FAIL,
            self::ON_PASS_FAIL,
            self::ON_FAIL_FAIL,
            self::NOT_FIXED
        ));
    }

    public function isOk()
    {
        return $this->isState(array(
            self::OK,
            self::ON_PASS_OK,
            self::ON_FAIL_OK,
            self::FIXED
        ));
    }

}
